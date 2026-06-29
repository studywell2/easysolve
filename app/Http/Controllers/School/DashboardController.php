<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Homework;
use App\Models\Exam;
use App\Models\Announcement;
use App\Models\SchoolEvent;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $school = $user->school;

        // Students/parents get a simple dashboard — skip heavy queries
        if (!$user->canManageSchool()) {
            $children = $user->isParent()
                ? $user->children()->with(['schoolClass', 'section'])->get()
                : collect();

            // Student attendance stats
            $attendanceStats = null;
            if ($user->isStudent()) {
                $total = Attendance::where('student_id', $user->id)->count();
                $present = Attendance::where('student_id', $user->id)->where('status', 'present')->count();
                $absent = Attendance::where('student_id', $user->id)->where('status', 'absent')->count();
                $late = Attendance::where('student_id', $user->id)->where('status', 'late')->count();
                $lastRecord = Attendance::where('student_id', $user->id)->latest('date')->first();

                $attendanceStats = [
                    'total' => $total,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'rate' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                    'last_status' => $lastRecord?->status,
                    'last_date' => $lastRecord?->date?->format('M d, Y'),
                ];
            }

            // Parent: per-child attendance stats
            $childAttendanceStats = [];
            if ($user->isParent()) {
                foreach ($children as $child) {
                    $total = Attendance::where('student_id', $child->id)->count();
                    $present = Attendance::where('student_id', $child->id)->where('status', 'present')->count();
                    $childAttendanceStats[$child->id] = [
                        'total' => $total,
                        'present' => $present,
                        'rate' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                    ];
                }
            }

            // Student dashboard widgets
            $gradeSummary = null;
            $pendingHomework = collect();
            $upcomingExams = collect();
            $recentAnnouncements = collect();
            $upcomingEvents = collect();

            if ($user->isStudent()) {
                $currentTerm = $school?->currentTerm;

                // Grade Performance Summary
                if ($currentTerm) {
                    $grades = Grade::where('student_id', $user->id)
                        ->where('term_id', $currentTerm->id)
                        ->with('subject')
                        ->get();

                    if ($grades->isNotEmpty()) {
                        $totalScore = $grades->sum('total_score');
                        $average = $totalScore / $grades->count();

                        $gradeSummary = [
                            'grades' => $grades,
                            'average' => round($average, 1),
                            'overall_grade' => Grade::calculateGrade($average),
                            'total_score' => $totalScore,
                            'subject_count' => $grades->count(),
                            'term_name' => $currentTerm->name,
                        ];
                    }
                }

                // Pending Homework
                $pendingHomework = Homework::where('class_id', $user->class_id)
                    ->where('status', 'open')
                    ->with(['subject', 'submissions' => fn($q) => $q->where('student_id', $user->id)])
                    ->latest('due_date')
                    ->take(5)
                    ->get();

                // Upcoming Exams (published, not yet ended)
                $upcomingExams = Exam::published()
                    ->where('class_id', $user->class_id)
                    ->where('end_date', '>=', today())
                    ->with(['schedules.subject'])
                    ->orderBy('start_date')
                    ->take(3)
                    ->get();

                // Recent Announcements
                $recentAnnouncements = Announcement::visibleTo($user)
                    ->with('creator')
                    ->latest()
                    ->take(3)
                    ->get();

                // Upcoming Events
                $upcomingEvents = SchoolEvent::visibleTo($user)
                    ->upcoming()
                    ->take(3)
                    ->get();
            }

            // Parents also get announcements and events
            if ($user->isParent()) {
                $recentAnnouncements = Announcement::visibleTo($user)
                    ->with('creator')
                    ->latest()
                    ->take(3)
                    ->get();

                $upcomingEvents = SchoolEvent::visibleTo($user)
                    ->upcoming()
                    ->take(3)
                    ->get();
            }

            return view('school.dashboard', compact(
                'children', 'attendanceStats', 'childAttendanceStats',
                'gradeSummary', 'pendingHomework', 'upcomingExams',
                'recentAnnouncements', 'upcomingEvents'
            ));
        }

        $stats = [
            'users' => User::where('school_id', $school->id)->count(),
            'teachers' => User::where('school_id', $school->id)->where('role', 'teacher')->count(),
            'students' => User::where('school_id', $school->id)->where('role', 'student')->count(),
            'classes' => SchoolClass::where('school_id', $school->id)->count(),
            'sections' => \App\Models\Section::whereHas('schoolClass', fn($q) => $q->where('school_id', $school->id))->count(),
            'revenue' => Payment::where('school_id', $school->id)->completed()->sum('amount'),
            'payments' => Payment::where('school_id', $school->id)->completed()
                ->whereMonth('paid_at', now()->month)->count(),
            'attendance_rate' => $this->attendanceRate($school->id),
        ];

        $recentUsers = User::where('school_id', $school->id)->latest()->take(5)->get();
        $recentPayments = Payment::where('school_id', $school->id)
            ->with(['student', 'fee'])->latest()->take(5)->get();

        // ===== Chart Data =====

        // Monthly revenue (last 6 months)
        $revenueMonths = [];
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueMonths[] = $month->format('M');
            $revenueData[] = (float) Payment::where('school_id', $school->id)
                ->completed()
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('amount');
        }

        // Attendance breakdown
        $attendanceBreakdown = [
            'present' => Attendance::where('school_id', $school->id)->where('status', 'present')->count(),
            'absent' => Attendance::where('school_id', $school->id)->where('status', 'absent')->count(),
            'late' => Attendance::where('school_id', $school->id)->where('status', 'late')->count(),
        ];

        // User distribution
        $userDistribution = [
            'students' => $stats['students'],
            'teachers' => $stats['teachers'],
            'admins' => User::where('school_id', $school->id)->where('role', 'admin')->count()
                + User::where('school_id', $school->id)->where('role', 'owner')->count(),
        ];

        // Enrollment trend (last 6 months)
        $enrollmentMonths = [];
        $enrollmentData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $enrollmentMonths[] = $month->format('M');
            $enrollmentData[] = User::where('school_id', $school->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        $chartData = [
            'revenue' => [
                'labels' => $revenueMonths,
                'data' => $revenueData,
            ],
            'attendance' => $attendanceBreakdown,
            'users' => $userDistribution,
            'enrollment' => [
                'labels' => $enrollmentMonths,
                'data' => $enrollmentData,
            ],
        ];

        return view('school.dashboard', compact('stats', 'recentUsers', 'recentPayments', 'chartData'));
    }

    private function attendanceRate(int $schoolId): float
    {
        $total = Attendance::where('school_id', $schoolId)->count();
        if ($total === 0) return 0;

        $present = Attendance::where('school_id', $schoolId)
            ->where('status', 'present')->count();

        return round(($present / $total) * 100, 1);
    }
}