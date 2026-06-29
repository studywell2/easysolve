<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Mail\GradePublishedMail;
use App\Models\Grade;
use App\Models\HomeworkSubmission;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        // Load homework averages per student/subject for the HW Avg column
        $homeworkAverages = collect();

        // Query homework graded submissions independently (not tied to existing grade rows)
        $hwQuery = HomeworkSubmission::where('status', 'graded')
            ->whereHas('homework', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->with('homework')
            ->whereHas('student', function ($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });

        // Apply same filters as grades
        if ($request->filled('class_id')) {
            $hwQuery->whereHas('homework', fn($q) => $q->where('class_id', $request->class_id));
        }
        if ($request->filled('subject_id')) {
            $hwQuery->whereHas('homework', fn($q) => $q->where('subject_id', $request->subject_id));
        }

        $hwSubs = $hwQuery->get();

        // Build averages keyed by student_id-subject_id
        $grouped = $hwSubs->groupBy(fn($s) => $s->student_id . '-' . ($s->homework->subject_id ?? 'none'));
        foreach ($grouped as $key => $subs) {
            $avg = $subs->avg(function ($s) {
                return $s->homework->max_score > 0
                    ? ($s->score / $s->homework->max_score) * 100
                    : 0;
            });
            $homeworkAverages[$key] = round($avg, 1);
        }

        // Also build a standalone homework list for display when no grades exist
        $homeworkSubmissions = $hwSubs->groupBy(function ($s) {
            return $s->student_id . '-' . ($s->homework->subject_id ?? 'none') . '-' . $s->homework_id;
        })->map(function ($subs) {
            $first = $subs->first();
            return [
                'student_name' => $first->student?->full_name ?? 'N/A',
                'homework_title' => $first->homework?->title ?? 'N/A',
                'subject_name' => $first->homework?->subject?->name ?? 'N/A',
                'score' => $first->score,
                'max_score' => $first->homework?->max_score ?? 100,
                'graded_at' => $first->graded_at,
            ];
        })->values();

        return view('school.grades.index', compact('grades', 'classes', 'subjects', 'terms', 'homeworkAverages', 'homeworkSubmissions'));
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
                $q->whereIn('academic_session_id', function ($sub) use ($schoolId) {
                    $sub->select('id')->from('academic_sessions')->where('school_id', $schoolId);
                });
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

        // Notify student's parent
        $this->notifyGradePublished($validated['student_id'], $validated['subject_id'], $validated['term_id']);

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

    // ─── Bulk Grade Entry ─────────────────────────────

    public function bulkCreate(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        $students = collect();
        $existingGrades = collect();

        if ($request->filled(['class_id', 'subject_id', 'term_id'])) {
            $students = User::where('school_id', $schoolId)
                ->where('role', 'student')
                ->where('class_id', $request->class_id)
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();

            $existingGrades = Grade::where('school_id', $schoolId)
                ->where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->where('term_id', $request->term_id)
                ->get()
                ->keyBy('student_id');
        }

        return view('school.grades.bulk', compact('classes', 'subjects', 'terms', 'students', 'existingGrades'));
    }

    public function bulkStore(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'subject_id' => ['required', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'term_id' => ['required', Rule::exists('terms', 'id')->where(function ($q) use ($schoolId) {
                $q->whereIn('academic_session_id', function ($sub) use ($schoolId) {
                    $sub->select('id')->from('academic_sessions')->where('school_id', $schoolId);
                });
            })],
            'grades' => 'required|array',
            'grades.*.student_id' => ['required', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'student')],
            'grades.*.ca_score' => 'nullable|numeric|min:0|max:40',
            'grades.*.exam_score' => 'nullable|numeric|min:0|max:60',
            'grades.*.remarks' => 'nullable|string|max:500',
        ]);

        $saved = 0;
        foreach ($validated['grades'] as $row) {
            // Skip rows where both scores are empty/null
            if (empty($row['ca_score']) && empty($row['exam_score'])) {
                continue;
            }

            $ca = (float) ($row['ca_score'] ?? 0);
            $exam = (float) ($row['exam_score'] ?? 0);
            $total = $ca + $exam;

            Grade::updateOrCreate(
                [
                    'school_id' => $schoolId,
                    'student_id' => $row['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'term_id' => $validated['term_id'],
                ],
                [
                    'class_id' => $validated['class_id'],
                    'ca_score' => $ca,
                    'exam_score' => $exam,
                    'total_score' => $total,
                    'grade' => Grade::calculateGrade($total),
                    'remarks' => $row['remarks'] ?? null,
                ]
            );

            // Notify student's parent
            $this->notifyGradePublished($row['student_id'], $validated['subject_id'], $validated['term_id']);

            $saved++;
        }

        return redirect()->route('school.grades.index')
            ->with('success', "{$saved} grade(s) saved successfully.");
    }

    // ─── Email Notification Helper ────────────────────

    private function notifyGradePublished(int $studentId, int $subjectId, int $termId): void
    {
        $grade = Grade::with(['student.parent', 'subject', 'term.academicSession'])
            ->where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('term_id', $termId)
            ->first();

        if (!$grade) return;

        // Send to parent if exists
        if ($grade->student?->parent?->email) {
            Mail::to($grade->student->parent->email)->queue(new GradePublishedMail($grade, $grade->term));
        }

        // Also send to student if they have email
        if ($grade->student?->email && $grade->student->email !== $grade->student?->parent?->email) {
            Mail::to($grade->student->email)->queue(new GradePublishedMail($grade, $grade->term));
        }
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