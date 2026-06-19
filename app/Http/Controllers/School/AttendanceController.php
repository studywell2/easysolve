<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();

        $query = Attendance::where('school_id', $schoolId)->with(['student', 'schoolClass']);

        // Determine which student's attendance to show
        $viewingStudent = null;
        $children = collect();

        if ($user->isStudent()) {
            $query->where('student_id', $user->id);
            $viewingStudent = $user;
        } elseif ($user->isParent()) {
            $children = $user->children()->with('schoolClass')->get();
            if ($request->filled('student')) {
                $viewingStudent = $children->firstWhere('id', $request->student);
                if ($viewingStudent) {
                    $query->where('student_id', $viewingStudent->id);
                } else {
                    $query->whereRaw('1 = 0'); // No results if invalid student
                }
            } elseif ($children->count() === 1) {
                $viewingStudent = $children->first();
                $query->where('student_id', $viewingStudent->id);
            } else {
                $query->whereRaw('1 = 0'); // No results until a child is selected
            }
        }

        // Filters
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest('date')->paginate(20)->appends($request->query());

        // Build summary stats for students and parents
        $summary = null;
        if ($viewingStudent) {
            $total = Attendance::where('student_id', $viewingStudent->id)->count();
            $present = Attendance::where('student_id', $viewingStudent->id)->where('status', 'present')->count();
            $absent = Attendance::where('student_id', $viewingStudent->id)->where('status', 'absent')->count();
            $late = Attendance::where('student_id', $viewingStudent->id)->where('status', 'late')->count();
            $excused = Attendance::where('student_id', $viewingStudent->id)->where('status', 'excused')->count();

            $summary = [
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'excused' => $excused,
                'rate' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
            ];
        }

        return view('school.attendance.index', compact('attendances', 'classes', 'summary', 'viewingStudent', 'children'));
    }

    public function create(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()
            ->with(['sections' => fn($q) => $q->withCount('students')->orderBy('name')])
            ->get();

        $selectedClass = $request->filled('class_id')
            ? $classes->firstWhere('id', $request->class_id)
            : $classes->first();

        // Group students by section, then add unassigned students
        $sectionGroups = collect();
        $unassignedStudents = collect();

        if ($selectedClass) {
            $selectedClass->loadMissing(['sections.students' => fn($q) => $q->where('role', 'student')->orderBy('last_name')]);

            foreach ($selectedClass->sections as $section) {
                if ($section->students->isNotEmpty()) {
                    $sectionGroups->push([
                        'section' => $section,
                        'students' => $section->students,
                    ]);
                }
            }

            // Students in the class but not in any section
            $unassignedStudents = User::where('school_id', $schoolId)
                ->where('class_id', $selectedClass->id)
                ->where('role', 'student')
                ->whereNull('section_id')
                ->orderBy('last_name')
                ->get();
        }

        return view('school.attendance.create', compact('classes', 'selectedClass', 'sectionGroups', 'unassignedStudents'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => ['required', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'student')],
            'attendance.*.status' => 'required|in:present,absent,late,excused',
        ]);

        $schoolId = auth()->user()->school_id;

        foreach ($validated['attendance'] as $record) {
            Attendance::updateOrCreate(
                [
                    'school_id' => $schoolId,
                    'student_id' => $record['student_id'],
                    'class_id' => $validated['class_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $record['status'],
                    'marked_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('school.attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function getStudents(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $request->validate([
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
        ]);

        $students = User::where('school_id', $schoolId)
            ->where('class_id', $request->class_id)
            ->where('role', 'student')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name']);

        return response()->json($students);
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
