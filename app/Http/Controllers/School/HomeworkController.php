<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HomeworkController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();

        $query = Homework::where('school_id', $schoolId)->with(['schoolClass', 'subject', 'teacher']);

        // Role-based filtering
        if ($user->isStudent()) {
            $query->where('class_id', $user->class_id);
        } elseif ($user->isParent()) {
            $childrenClassIds = $user->children()->pluck('class_id')->filter();
            $query->whereIn('class_id', $childrenClassIds);
        } elseif ($user->isTeacher()) {
            $query->where('teacher_id', $user->id);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $homework = $query->latest('due_date')->paginate(15)->appends($request->query());

        return view('school.homework.index', compact('homework', 'classes', 'subjects'));
    }

    public function create()
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $terms = Term::whereHas('academicSession', fn ($q) => $q->where('school_id', $schoolId))->get();

        return view('school.homework.create', compact('classes', 'subjects', 'terms'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'subject_id' => ['nullable', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'term_id' => ['nullable', Rule::exists('terms', 'id')->where(function ($q) use ($schoolId) {
                $q->whereIn('academic_session_id', function ($sub) use ($schoolId) {
                    $sub->select('id')->from('academic_sessions')->where('school_id', $schoolId);
                });
            })],
            'due_date' => 'required|date|after_or_equal:today',
            'max_score' => 'nullable|numeric|min:1|max:999',
        ]);

        Homework::create([
            ...$validated,
            'school_id' => $schoolId,
            'teacher_id' => auth()->id(),
            'max_score' => $validated['max_score'] ?? 100,
        ]);

        return redirect()->route('school.homework.index')->with('success', 'Homework assignment created successfully.');
    }

    public function show(Homework $homework)
    {
        $this->authorizeAccess($homework);
        $user = auth()->user();

        $homework->load(['schoolClass', 'subject', 'teacher', 'term']);

        $submissions = collect();
        $studentSubmission = null;
        $stats = null;
        $notSubmittedStudents = collect();

        if ($user->canManageSchool()) {
            $submissions = $homework->submissions()
                ->with(['student'])
                ->latest()
                ->paginate(20, ['*'], 'submissions_page');

            // Submission statistics
            $totalStudents = User::where('class_id', $homework->class_id)
                ->where('role', 'student')
                ->where('is_active', true)
                ->count();

            $submittedCount = $homework->submissions()
                ->whereIn('status', ['submitted', 'graded', 'late'])
                ->count();
            $gradedCount = $homework->submissions()->where('status', 'graded')->count();
            $lateCount = $homework->submissions()->where('status', 'late')->count();
            $notSubmittedCount = max(0, $totalStudents - $submittedCount);

            $stats = (object) [
                'total' => $totalStudents,
                'submitted' => $submittedCount,
                'graded' => $gradedCount,
                'late' => $lateCount,
                'notSubmitted' => $notSubmittedCount,
            ];

            // Students who haven't submitted
            $submittedStudentIds = $homework->submissions()->pluck('student_id')->toArray();
            $notSubmittedStudents = User::where('class_id', $homework->class_id)
                ->where('role', 'student')
                ->where('is_active', true)
                ->whereNotIn('id', $submittedStudentIds)
                ->orderBy('first_name')
                ->get();
        } elseif ($user->isStudent()) {
            $studentSubmission = $homework->submissions()->where('student_id', $user->id)->first();
        } elseif ($user->isParent()) {
            $childrenIds = $user->children()->pluck('id');
            $studentSubmission = $homework->submissions()->whereIn('student_id', $childrenIds)->with('student')->get();
        }

        return view('school.homework.show', compact('homework', 'submissions', 'studentSubmission', 'stats', 'notSubmittedStudents'));
    }

    public function edit(Homework $homework)
    {
        $this->authorizeAccess($homework);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $terms = Term::whereHas('academicSession', fn ($q) => $q->where('school_id', $schoolId))->get();

        return view('school.homework.edit', compact('homework', 'classes', 'subjects', 'terms'));
    }

    public function update(Request $request, Homework $homework)
    {
        $this->authorizeAccess($homework);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'class_id' => ['required', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'subject_id' => ['nullable', Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
            'term_id' => ['nullable', Rule::exists('terms', 'id')->where(function ($q) use ($schoolId) {
                $q->whereIn('academic_session_id', function ($sub) use ($schoolId) {
                    $sub->select('id')->from('academic_sessions')->where('school_id', $schoolId);
                });
            })],
            'due_date' => 'required|date',
            'max_score' => 'nullable|numeric|min:1|max:999',
            'status' => 'required|in:open,closed',
        ]);

        $homework->update($validated);

        return redirect()->route('school.homework.index')->with('success', 'Homework assignment updated successfully.');
    }

    public function destroy(Homework $homework)
    {
        $this->authorizeAccess($homework);
        $this->authorizeManager();
        $homework->delete();

        return redirect()->route('school.homework.index')->with('success', 'Homework assignment deleted successfully.');
    }

    // ─── Student Submission ───────────────────────────

    public function submit(Request $request, Homework $homework)
    {
        $this->authorizeAccess($homework);
        $user = auth()->user();

        if (!$user->isStudent()) {
            abort(403);
        }

        if ($homework->status === 'closed') {
            return back()->with('error', 'This homework assignment is closed.');
        }

        $validated = $request->validate([
            'content' => 'nullable|string|max:10000',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:10240', // 10MB max
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('homework-submissions', 'public');
        }

        $isLate = $homework->due_date->isPast();

        HomeworkSubmission::updateOrCreate(
            [
                'homework_id' => $homework->id,
                'student_id' => $user->id,
            ],
            [
                'content' => $validated['content'] ?? null,
                'file_path' => $filePath,
                'submitted_at' => now(),
                'status' => $isLate ? 'late' : 'submitted',
            ]
        );

        return redirect()->route('school.homework.show', $homework)->with('success', 'Homework submitted successfully.');
    }

    // ─── Teacher Grading ──────────────────────────────

    public function grade(Request $request, HomeworkSubmission $submission)
    {
        $this->authorizeAccess($submission->homework);
        $this->authorizeManager();

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:' . $submission->homework->max_score,
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'] ?? null,
            'status' => 'graded',
            'graded_by' => auth()->id(),
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Submission graded successfully.');
    }

    // ─── Close / Reopen ───────────────────────────────

    public function close(Homework $homework)
    {
        $this->authorizeAccess($homework);
        $this->authorizeManager();

        $homework->update([
            'status' => $homework->status === 'open' ? 'closed' : 'open',
        ]);

        $message = $homework->status === 'open'
            ? 'Homework assignment reopened. Students can now submit.'
            : 'Homework assignment closed. Students can no longer submit.';

        return back()->with('success', $message);
    }

    // ─── Download Submission File ──────────────────────

    public function downloadFile(HomeworkSubmission $submission)
    {
        $this->authorizeAccess($submission->homework);
        $user = auth()->user();

        if (!$user->canManageSchool() && $submission->student_id !== $user->id) {
            abort(403);
        }

        if (!$submission->file_path) {
            abort(404, 'No file attached to this submission.');
        }

        return Storage::disk('public')->download($submission->file_path);
    }

    // ─── Private Helpers ──────────────────────────────

    private function authorizeAccess(Homework $homework): void
    {
        if ($homework->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $user = auth()->user();

        if ($user->isStudent() && $homework->class_id !== $user->class_id) {
            abort(403);
        }

        if ($user->isParent()) {
            $childrenClassIds = $user->children()->pluck('class_id')->toArray();
            if (!in_array($homework->class_id, $childrenClassIds)) {
                abort(403);
            }
        }
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}
