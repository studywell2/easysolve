@extends('layouts.school')

@section('title', 'Staff Attendance')
@section('subtitle', 'Clock in & out · Track your work hours')

@section('content')
    <div class="animate-fade-up">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Staff Attendance</h1>
                <p class="text-sm text-slate-400 mt-0.5">Sign in and out · {{ now()->format('l, F j, Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-right">
                    <p class="text-2xl font-extrabold text-slate-900 tabular-nums" id="live-clock">{{ now()->format('g:i:s A') }}</p>
                    <p class="text-[11px] text-slate-400">Current time</p>
                </div>
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
            </div>
        </div>

        {{-- Clock In / Out Card --}}
        <div class="max-w-2xl mb-6">
            @if ($todayRecord && $todayRecord->isClockedIn())
                {{-- Currently Clocked In --}}
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl shadow-xl shadow-emerald-500/20 overflow-hidden">
                    <div class="px-8 py-7">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-white flex items-center justify-center">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-emerald-100 uppercase tracking-wider">You're Clocked In</p>
                                <p class="text-lg font-bold text-white mt-0.5">Signed in at {{ $todayRecord->formatted_clock_in }}</p>
                                <p class="text-xs text-emerald-100 mt-0.5">
                                    Working for <span id="working-duration" data-clock-in="{{ $todayRecord->clock_in_at->toISOString() }}">{{ $todayRecord->formatted_duration }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-4 bg-white/10 backdrop-blur border-t border-white/10">
                        <form action="{{ route('school.staff-attendance.clock-out') }}" method="POST">
                            @csrf
                            <div class="flex items-center gap-3">
                                <input type="text" name="notes" placeholder="Add a note before clocking out (optional)…"
                                    class="flex-1 bg-white/15 backdrop-blur border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-emerald-100/70 focus:outline-none focus:bg-white/25 transition">
                                <button type="submit" class="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 text-emerald-700 font-bold px-6 py-2.5 rounded-xl shadow-lg transition text-sm whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                                    Clock Out
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($todayRecord && $todayRecord->isClockedOut())
                {{-- Already Clocked Out --}}
                <div class="bg-gradient-to-br from-slate-100 to-gray-200 rounded-3xl shadow-sm overflow-hidden border border-gray-200">
                    <div class="px-8 py-7">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Day Complete</p>
                                <p class="text-lg font-bold text-slate-700 mt-0.5">You've clocked out for today</p>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-xs text-slate-500">In: <strong class="text-slate-700">{{ $todayRecord->formatted_clock_in }}</strong></span>
                                    <span class="text-xs text-slate-500">Out: <strong class="text-slate-700">{{ $todayRecord->formatted_clock_out }}</strong></span>
                                    <span class="text-xs text-slate-500">Total: <strong class="text-emerald-600">{{ $todayRecord->formatted_duration }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Not Clocked In Yet --}}
                <div class="bg-gradient-to-br from-brand-500 to-indigo-600 rounded-3xl shadow-xl shadow-brand-500/20 overflow-hidden">
                    <div class="px-8 py-7">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-brand-100 uppercase tracking-wider">Not Signed In</p>
                                <p class="text-lg font-bold text-white mt-0.5">Ready to start your day?</p>
                                <p class="text-xs text-brand-100 mt-0.5">Clock in to record your attendance</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-4 bg-white/10 backdrop-blur border-t border-white/10">
                        <form action="{{ route('school.staff-attendance.clock-in') }}" method="POST">
                            @csrf
                            <div class="flex items-center gap-3">
                                <input type="text" name="notes" placeholder="Add a note (optional)…"
                                    class="flex-1 bg-white/15 backdrop-blur border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-brand-100/70 focus:outline-none focus:bg-white/25 transition">
                                <button type="submit" class="inline-flex items-center gap-2 bg-white hover:bg-brand-50 text-brand-700 font-bold px-6 py-2.5 rounded-xl shadow-lg transition text-sm whitespace-nowrap">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    Clock In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        {{-- Admin: Today's Summary --}}
        @if(!auth()->user()->isTeacher() && isset($todayStats))
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-emerald-600">{{ $todayStats['clocked_in'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Clocked In Now</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-blue-600">{{ $todayStats['completed'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Completed Today</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-amber-600">{{ $todayStats['not_clocked_in'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Not Clocked In</p>
            </div>
        </div>
        @endif

        {{-- Teacher: Personal Stats --}}
        @if(auth()->user()->isTeacher() && isset($stats))
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-brand-600">{{ $stats['total_days'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Total Days Recorded</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-emerald-600">{{ $stats['present_days'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Completed Days</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-purple-600">{{ $stats['avg_hours'] }}h</p>
                <p class="text-xs text-slate-400 mt-0.5">Avg Hours / Day</p>
            </div>
        </div>
        @endif

        {{-- Admin: Filters --}}
        @if(!auth()->user()->isTeacher() && isset($staff))
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="user_id" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Staff</option>
                    @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ request('user_id') == $s->id ? 'selected' : '' }}>{{ $s->full_name }} ({{ ucfirst($s->role) }})</option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5H14.25M14.25 4.5V9m0-4.5H21M14.25 4.5L21 9M3 19.5h6.75M9.75 19.5V15m0 4.5H3M9.75 19.5L3 15"/></svg>
                    Filter
                </button>
                <a href="{{ route('school.staff-attendance.index') }}" class="px-4 py-2.5 text-slate-500 text-sm rounded-xl hover:bg-gray-100 transition">Clear</a>
            </form>
        </div>
        @endif

        {{-- History Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">
                        @if(auth()->user()->isTeacher())
                            My Attendance History
                        @else
                            Staff Attendance Records
                        @endif
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $records->total() }} records</p>
                </div>
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full data-table">
                    <thead>
                        <tr>
                            @if(!auth()->user()->isTeacher())
                            <th class="text-left px-6 py-4">Staff Member</th>
                            @endif
                            <th class="text-left px-6 py-4">Date</th>
                            <th class="text-center px-6 py-4">Clock In</th>
                            <th class="text-center px-6 py-4">Clock Out</th>
                            <th class="text-center px-6 py-4">Duration</th>
                            <th class="text-center px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($records as $record)
                            <tr class="group">
                                @if(!auth()->user()->isTeacher())
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center text-brand-600 font-bold text-xs border border-brand-100/50 flex-shrink-0">
                                            {{ strtoupper(substr($record->user?->first_name ?? '?', 0, 1) . substr($record->user?->last_name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $record->user?->full_name ?? 'Unknown' }}</p>
                                            <p class="text-[11px] text-slate-400 capitalize">{{ $record->user?->role ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                @endif
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-700">{{ $record->date->format('M d, Y') }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $record->date->format('l') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($record->clock_in_at)
                                        <span class="text-sm font-medium text-slate-700">{{ $record->formatted_clock_in }}</span>
                                    @else
                                        <span class="text-xs text-slate-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($record->clock_out_at)
                                        <span class="text-sm font-medium text-slate-700">{{ $record->formatted_clock_out }}</span>
                                    @else
                                        <span class="text-xs text-slate-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($record->clock_in_at)
                                        <span class="text-sm font-bold text-slate-700 tabular-nums">{{ $record->formatted_duration }}</span>
                                    @else
                                        <span class="text-xs text-slate-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($record->isClockedIn())
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Clocked In
                                        </span>
                                    @elseif($record->isClockedOut())
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full bg-slate-50 text-slate-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Incomplete
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isTeacher() ? '5' : '6' }}" class="px-6 py-16 text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No attendance records found</p>
                                    <p class="text-xs text-slate-300 mt-1">Records will appear here once staff start clocking in.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($records->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $records->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
        // Live clock
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Live working duration
        const durationEl = document.getElementById('working-duration');
        if (durationEl) {
            const clockInTime = new Date(durationEl.dataset.clockIn);

            function updateDuration() {
                const now = new Date();
                const diffMs = now - clockInTime;
                const hours = Math.floor(diffMs / 3600000);
                const minutes = Math.floor((diffMs % 3600000) / 60000);
                const seconds = Math.floor((diffMs % 60000) / 1000);

                if (hours > 0) {
                    durationEl.textContent = `${hours}h ${minutes}m ${seconds}s`;
                } else if (minutes > 0) {
                    durationEl.textContent = `${minutes}m ${seconds}s`;
                } else {
                    durationEl.textContent = `${seconds}s`;
                }
            }
            setInterval(updateDuration, 1000);
            updateDuration();
        }
    </script>
@endsection
