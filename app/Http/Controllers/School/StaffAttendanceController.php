<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffAttendanceController extends Controller
{
    /**
     * Display staff attendance — teachers see their own, admins/owners see all.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Today's record for the current user
        $todayRecord = $user->todayStaffAttendance;

        if ($user->isTeacher()) {
            // Teachers: show their own history
            $records = StaffAttendance::where('user_id', $user->id)
                ->latest('date')
                ->paginate(20, ['*'], 'page')
                ->appends($request->query());

            // Summary stats for this teacher
            $stats = [
                'total_days' => StaffAttendance::where('user_id', $user->id)->count(),
                'present_days' => StaffAttendance::where('user_id', $user->id)->whereNotNull('clock_out_at')->count(),
                'avg_hours' => StaffAttendance::where('user_id', $user->id)
                    ->whereNotNull('clock_out_at')
                    ->selectRaw('AVG(EXTRACT(EPOCH FROM (clock_out_at - clock_in_at)) / 60) as avg')
                    ->value('avg'),
            ];
            $stats['avg_hours'] = $stats['avg_hours'] ? round($stats['avg_hours'] / 60, 1) : 0;

            return view('school.staff-attendance.index', compact('todayRecord', 'records', 'stats'));
        }

        // Admins & Owners: show all staff attendance
        $query = StaffAttendance::where('school_id', $schoolId)
            ->with(['user']);

        // Get staff list for filter
        $staff = User::where('school_id', $schoolId)
            ->whereIn('role', ['owner', 'admin', 'teacher'])
            ->orderBy('first_name')
            ->get();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        } else {
            // Default to today
            $query->where('date', today());
        }

        $records = $query->latest('clock_in_at')->paginate(20)->appends($request->query());

        // Today's summary
        $todayStats = [
            'clocked_in' => StaffAttendance::where('school_id', $schoolId)
                ->where('date', today())
                ->whereNull('clock_out_at')
                ->count(),
            'completed' => StaffAttendance::where('school_id', $schoolId)
                ->where('date', today())
                ->whereNotNull('clock_out_at')
                ->count(),
            'not_clocked_in' => $staff->count() - StaffAttendance::where('school_id', $schoolId)
                ->where('date', today())->distinct('user_id')->count('user_id'),
        ];

        return view('school.staff-attendance.index', compact('todayRecord', 'records', 'staff', 'todayStats'));
    }

    /**
     * Clock in the current user.
     */
    public function clockIn(Request $request)
    {
        $user = auth()->user();

        $existing = $user->todayStaffAttendance;

        if ($existing && $existing->clock_in_at) {
            return back()->with('error', 'You have already clocked in today at ' . $existing->clock_in_at->format('g:i A') . '.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        StaffAttendance::updateOrCreate(
            [
                'user_id' => $user->id,
                'date' => today(),
            ],
            [
                'school_id' => $user->school_id,
                'clock_in_at' => now(),
                'clock_in_ip' => $request->ip(),
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return back()->with('success', 'Clocked in at ' . now()->format('g:i A') . '. Have a great day!');
    }

    /**
     * Clock out the current user.
     */
    public function clockOut(Request $request)
    {
        $user = auth()->user();

        $record = $user->todayStaffAttendance;

        if (! $record || ! $record->clock_in_at) {
            return back()->with('error', 'You need to clock in first before clocking out.');
        }

        if ($record->clock_out_at) {
            return back()->with('error', 'You have already clocked out today at ' . $record->clock_out_at->format('g:i A') . '.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $record->update([
            'clock_out_at' => now(),
            'clock_out_ip' => $request->ip(),
            'notes' => $validated['notes'] ?? $record->notes,
        ]);

        $duration = $record->fresh()->formatted_duration;

        return back()->with('success', "Clocked out at " . now()->format('g:i A') . ". You worked {$duration} today. Great job!");
    }
}
