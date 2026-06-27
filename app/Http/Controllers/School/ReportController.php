<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Grade;
use App\Models\Term;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        // Enrollment summary
        $enrollment = User::where('school_id', $schoolId)
            ->select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');

        // Attendance summary (current term)
        $attendanceSummary = Attendance::where('school_id', $schoolId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Financial summary
        $totalFees = \App\Models\Fee::where('school_id', $schoolId)->active()->sum('amount');
        $totalPaid = Payment::where('school_id', $schoolId)->completed()->sum('amount');
        $totalOutstanding = max(0, $totalFees - $totalPaid);

        // Grade distribution
        $gradeDistribution = Grade::where('school_id', $schoolId)
            ->select('grade', DB::raw('count(*) as count'))
            ->groupBy('grade')
            ->pluck('count', 'grade');

        // Data for report card generation
        $classes = SchoolClass::where('school_id', $schoolId)->active()->get();
        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        return view('school.reports.index', compact(
            'enrollment', 'attendanceSummary', 'totalFees', 'totalPaid',
            'totalOutstanding', 'gradeDistribution', 'classes', 'terms'
        ));
    }

    // ─── Report Card PDF ──────────────────────────────

    public function selectReportCard(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $terms = Term::whereHas('academicSession', fn($q) => $q->where('school_id', $schoolId))->get();

        if ($user->isParent()) {
            $children = $user->children()->with(['schoolClass', 'section'])->get();
            $isManager = false;
            return view('school.reports.report-card-select', compact('children', 'terms', 'isManager'));
        }

        if ($user->isStudent()) {
            $student = $user->load(['schoolClass', 'section']);
            $isManager = false;
            $isStudent = true;
            return view('school.reports.report-card-select', compact('student', 'terms', 'isManager', 'isStudent'));
        }

        $this->authorizeManager();
        $classes = SchoolClass::where('school_id', $schoolId)->active()->with('students')->get();
        $isManager = true;
        return view('school.reports.report-card-select', compact('classes', 'terms', 'isManager'));
    }

    public function generateReportCard(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'term_id' => 'required|exists:terms,id',
        ]);

        $student = User::where('school_id', $schoolId)
            ->where('role', 'student')
            ->with(['schoolClass', 'section', 'school'])
            ->findOrFail($validated['student_id']);

        // Parents can only download report cards for their own children
        if ($user->isParent()) {
            if (!$user->children()->where('id', $student->id)->exists()) {
                abort(403, 'You can only download report cards for your own children.');
            }
        } elseif ($user->isStudent()) {
            if ($student->id !== $user->id) {
                abort(403, 'You can only download your own report card.');
            }
        } elseif (!$user->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }

        $term = Term::with('academicSession')->findOrFail($validated['term_id']);

        $grades = Grade::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->where('term_id', $term->id)
            ->with('subject')
            ->get();

        $attendance = Attendance::where('school_id', $schoolId)
            ->where('student_id', $student->id)
            ->whereHas('subject', fn($q) => $q->where('term_id', $term->id))
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Calculate summary stats
        $totalScore = $grades->sum('total_score');
        $subjectCount = $grades->count();
        $average = $subjectCount > 0 ? $totalScore / $subjectCount : 0;
        $overallGrade = Grade::calculateGrade($average);

        // Position in class
        $classmates = User::where('school_id', $schoolId)
            ->where('role', 'student')
            ->where('class_id', $student->class_id)
            ->pluck('id');

        $classAverages = [];
        foreach ($classmates as $classmateId) {
            $classmateTotal = Grade::where('student_id', $classmateId)
                ->where('term_id', $term->id)
                ->sum('total_score');
            $classmateCount = Grade::where('student_id', $classmateId)
                ->where('term_id', $term->id)
                ->count();
            $classAverages[$classmateId] = $classmateCount > 0 ? $classmateTotal / $classmateCount : 0;
        }
        arsort($classAverages);
        $position = array_search($student->id, array_keys($classAverages)) + 1;
        $totalStudents = count($classAverages);

        $data = compact('student', 'term', 'grades', 'attendance', 'totalScore', 'average', 'overallGrade', 'position', 'totalStudents');

        $pdf = Pdf::loadView('school.reports.report-card-pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        $filename = 'report-card-' . $student->first_name . '-' . $student->last_name . '-' . $term->name . '.pdf';

        return $pdf->download($filename);
    }

    // ─── Class Report Summary PDF ─────────────────────

    public function classReport(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'term_id' => 'required|exists:terms,id',
        ]);

        $class = SchoolClass::where('school_id', $schoolId)->findOrFail($validated['class_id']);
        $term = Term::with('academicSession')->findOrFail($validated['term_id']);

        $students = User::where('school_id', $schoolId)
            ->where('role', 'student')
            ->where('class_id', $validated['class_id'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $studentResults = [];
        foreach ($students as $student) {
            $grades = Grade::where('student_id', $student->id)
                ->where('term_id', $term->id)
                ->with('subject')
                ->get();

            $total = $grades->sum('total_score');
            $count = $grades->count();
            $average = $count > 0 ? $total / $count : 0;

            $studentResults[] = [
                'student' => $student,
                'grades' => $grades,
                'total' => $total,
                'average' => $average,
                'grade' => Grade::calculateGrade($average),
            ];
        }

        // Sort by average descending for position
        usort($studentResults, fn($a, $b) => $b['average'] <=> $a['average']);
        foreach ($studentResults as $i => &$result) {
            $result['position'] = $i + 1;
        }

        $data = compact('class', 'term', 'studentResults');

        $pdf = Pdf::loadView('school.reports.class-report-pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('class-report-' . $class->name . '-' . $term->name . '.pdf');
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}