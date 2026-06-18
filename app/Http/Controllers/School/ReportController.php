<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('school.reports.index', compact(
            'enrollment', 'attendanceSummary', 'totalFees', 'totalPaid',
            'totalOutstanding', 'gradeDistribution'
        ));
    }
}