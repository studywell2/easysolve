<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Role-based class filtering
        if ($user->isStudent()) {
            // Students: only see their own class timetable
            $classes = SchoolClass::where('school_id', $schoolId)
                ->where('id', $user->class_id)
                ->active()
                ->get();
            $selectedClass = $user->class_id;
        } elseif ($user->isParent()) {
            // Parents: only see their children's class timetables
            $childClassIds = $user->children()->whereNotNull('class_id')->pluck('class_id')->unique();
            $classes = SchoolClass::where('school_id', $schoolId)
                ->whereIn('id', $childClassIds)
                ->active()
                ->get();
            $selectedClass = $request->filled('class_id') ? $request->class_id : $classes->first()?->id;
        } else {
            // Managers: see all classes
            $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
            $selectedClass = $request->filled('class_id') ? $request->class_id : $classes->first()?->id;
        }

        $timetables = collect();
        if ($selectedClass) {
            $timetables = Timetable::where('school_id', $schoolId)
                ->where('class_id', $selectedClass)
                ->with(['subject', 'teacher'])
                ->orderByRaw("CASE day_of_week WHEN 'monday' THEN 1 WHEN 'tuesday' THEN 2 WHEN 'wednesday' THEN 3 WHEN 'thursday' THEN 4 WHEN 'friday' THEN 5 WHEN 'saturday' THEN 6 WHEN 'sunday' THEN 7 END")
                ->orderBy('start_time')
                ->get()
                ->groupBy('day_of_week');
        }

        $isManager = $user->canManageSchool();

        return view('school.timetable.index', compact('classes', 'timetables', 'selectedClass', 'isManager'));
    }

    public function create()
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $teachers = User::where('school_id', $schoolId)->where('role', 'teacher')->orderBy('first_name')->get();

        return view('school.timetable.create', compact('classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'subject_id' => ['required', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'teacher_id' => ['required', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'teacher')],
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
        ]);

        // Check for scheduling conflicts
        $conflict = Timetable::where('school_id', $schoolId)
            ->where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($sq) use ($validated) {
                        $sq->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Scheduling conflict: this class already has a lesson during the selected time slot.')
                ->withInput();
        }

        Timetable::create([
            ...$validated,
            'school_id' => $schoolId,
        ]);

        return redirect()->route('school.timetable.index', ['class_id' => $validated['class_id']])
            ->with('success', 'Timetable entry added successfully.');
    }

    public function edit(Timetable $timetable)
    {
        $this->authorizeAccess($timetable);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $teachers = User::where('school_id', $schoolId)->where('role', 'teacher')->orderBy('first_name')->get();

        return view('school.timetable.edit', compact('timetable', 'classes', 'subjects', 'teachers'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $this->authorizeAccess($timetable);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'subject_id' => ['required', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'teacher_id' => ['required', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'teacher')],
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
        ]);

        // Check for conflicts (excluding current entry)
        $conflict = Timetable::where('school_id', $schoolId)
            ->where('class_id', $validated['class_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('id', '!=', $timetable->id)
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($sq) use ($validated) {
                        $sq->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Scheduling conflict: this class already has a lesson during the selected time slot.')
                ->withInput();
        }

        $timetable->update($validated);

        return redirect()->route('school.timetable.index', ['class_id' => $validated['class_id']])
            ->with('success', 'Timetable entry updated successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $this->authorizeAccess($timetable);
        $this->authorizeManager();
        $classId = $timetable->class_id;
        $timetable->delete();

        return redirect()->route('school.timetable.index', ['class_id' => $classId])
            ->with('success', 'Timetable entry removed successfully.');
    }

    private function authorizeAccess(Timetable $timetable): void
    {
        if ($timetable->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
