<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        $query = Grade::where('school_id', $schoolId)->with(['student', 'subject', 'term', 'schoolClass']);

        // Students only see their own grades
        if (auth()->user()->isStudent()) {
            $query->where('student_id', auth()->id());
        }

        // Parents only see their children's grades
        if (auth()->user()->isParent()) {
            $query->whereHas('student', fn($q) => $q->where('parent_id', auth()->id()));
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('term_id')) {
            $query->where('term_id', $request->term_id);
        }

        $grades = $query->latest()->paginate(20)->appends($request->query());

        return view('school.grades.index', compact('grades', 'classes', 'subjects', 'terms'));
    }

    public function create()
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->with('students')->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        return view('school.grades.create', compact('classes', 'subjects', 'terms'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'student_id' => ['required', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'student')],
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'subject_id' => ['required', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'term_id' => ['required', Rule::exists('terms', 'id')->where(function ($q) use ($schoolId) {
                $q->whereHas('academicSession', fn($sq) => $sq->where('school_id', $schoolId));
            })],
            'ca_score' => 'required|numeric|min:0|max:40',
            'exam_score' => 'required|numeric|min:0|max:60',
            'remarks' => 'nullable|string|max:500',
        ]);

        $total = $validated['ca_score'] + $validated['exam_score'];

        Grade::updateOrCreate(
            [
                'school_id' => $schoolId,
                'student_id' => $validated['student_id'],
                'subject_id' => $validated['subject_id'],
                'term_id' => $validated['term_id'],
            ],
            [
                'class_id' => $validated['class_id'],
                'ca_score' => $validated['ca_score'],
                'exam_score' => $validated['exam_score'],
                'total_score' => $total,
                'grade' => Grade::calculateGrade($total),
                'remarks' => $validated['remarks'] ?? null,
            ]
        );

        return redirect()->route('school.grades.index')->with('success', 'Grade recorded successfully.');
    }

    public function edit(Grade $grade)
    {
        $this->authorizeAccess($grade);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->with('students')->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        return view('school.grades.edit', compact('grade', 'classes', 'subjects', 'terms'));
    }

    public function update(Request $request, Grade $grade)
    {
        $this->authorizeAccess($grade);
        $this->authorizeManager();

        $validated = $request->validate([
            'ca_score' => 'required|numeric|min:0|max:40',
            'exam_score' => 'required|numeric|min:0|max:60',
            'remarks' => 'nullable|string|max:500',
        ]);

        $total = $validated['ca_score'] + $validated['exam_score'];

        $grade->update([
            'ca_score' => $validated['ca_score'],
            'exam_score' => $validated['exam_score'],
            'total_score' => $total,
            'grade' => Grade::calculateGrade($total),
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('school.grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $this->authorizeAccess($grade);
        $this->authorizeManager();
        $grade->delete();

        return redirect()->route('school.grades.index')->with('success', 'Grade deleted successfully.');
    }

    private function authorizeAccess(Grade $grade): void
    {
        if ($grade->school_id !== auth()->user()->school_id) {
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