<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();

        $query = Exam::where('school_id', $schoolId)->with(['term', 'schoolClass', 'schedules.subject']);

        // Students only see published exams for their class
        if ($user->isStudent()) {
            $query->where('status', 'published')->where(function ($q) use ($user) {
                $q->where('class_id', $user->class_id)->orWhereNull('class_id');
            });
        } elseif ($user->isParent()) {
            $childrenClassIds = $user->children()->pluck('class_id')->filter()->toArray();
            $query->where('status', 'published')->where(function ($q) use ($childrenClassIds) {
                $q->whereIn('class_id', $childrenClassIds)->orWhereNull('class_id');
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $exams = $query->latest('start_date')->paginate(15)->appends($request->query());

        return view('school.exams.index', compact('exams', 'classes'));
    }

    public function create()
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $terms = Term::whereHas('academicSession', fn ($q) => $q->where('school_id', $schoolId))->get();

        return view('school.exams.create', compact('classes', 'terms'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'term_id' => ['nullable', Rule::exists('terms', 'id')->where(function ($q) use ($schoolId) {
                $q->whereIn('academic_session_id', function ($sub) use ($schoolId) {
                    $sub->select('id')->from('academic_sessions')->where('school_id', $schoolId);
                });
            })],
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exam = Exam::create([
            ...$validated,
            'school_id' => $schoolId,
            'status' => 'draft',
        ]);

        return redirect()->route('school.exams.show', $exam)->with('success', 'Exam created. Add subjects to the schedule below.');
    }

    public function show(Exam $exam)
    {
        $this->authorizeAccess($exam);

        $user = auth()->user();

        // Students/parents can only see published exams
        if (!$user->canManageSchool() && !$exam->isPublished()) {
            abort(403);
        }

        $exam->load(['term', 'schoolClass', 'schedules.subject']);
        $subjects = collect();

        if ($user->canManageSchool()) {
            $schoolId = $user->school_id;
            $subjects = Subject::where('school_id', $schoolId)->get();
        }

        return view('school.exams.show', compact('exam', 'subjects'));
    }

    public function edit(Exam $exam)
    {
        $this->authorizeAccess($exam);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $terms = Term::whereHas('academicSession', fn ($q) => $q->where('school_id', $schoolId))->get();

        return view('school.exams.edit', compact('exam', 'classes', 'terms'));
    }

    public function update(Request $request, Exam $exam)
    {
        $this->authorizeAccess($exam);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'term_id' => ['nullable', Rule::exists('terms', 'id')->where(function ($q) use ($schoolId) {
                $q->whereIn('academic_session_id', function ($sub) use ($schoolId) {
                    $sub->select('id')->from('academic_sessions')->where('school_id', $schoolId);
                });
            })],
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,published',
        ]);

        $exam->update($validated);

        return redirect()->route('school.exams.show', $exam)->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $this->authorizeAccess($exam);
        $this->authorizeManager();
        $exam->delete();

        return redirect()->route('school.exams.index')->with('success', 'Exam deleted successfully.');
    }

    // ─── Exam Schedule Management ─────────────────────

    public function storeSchedule(Request $request, Exam $exam)
    {
        $this->authorizeAccess($exam);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'subject_id' => ['required', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:100',
            'total_marks' => 'nullable|numeric|min:1|max:999',
            'notes' => 'nullable|string|max:1000',
        ]);

        ExamSchedule::create([
            ...$validated,
            'exam_id' => $exam->id,
            'total_marks' => $validated['total_marks'] ?? 100,
        ]);

        return back()->with('success', 'Exam subject added to schedule.');
    }

    public function destroySchedule(Exam $exam, ExamSchedule $schedule)
    {
        $this->authorizeAccess($exam);
        $this->authorizeManager();
        $schedule->delete();

        return back()->with('success', 'Exam schedule entry removed.');
    }

    public function publish(Exam $exam)
    {
        $this->authorizeAccess($exam);
        $this->authorizeManager();

        if ($exam->schedules()->count() === 0) {
            return back()->with('error', 'Cannot publish an exam with no scheduled subjects.');
        }

        $exam->update(['status' => 'published']);

        return redirect()->route('school.exams.show', $exam)->with('success', 'Exam timetable published. Students and parents can now view it.');
    }

    // ─── Private Helpers ──────────────────────────────

    private function authorizeAccess(Exam $exam): void
    {
        if ($exam->school_id !== auth()->user()->school_id) {
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
