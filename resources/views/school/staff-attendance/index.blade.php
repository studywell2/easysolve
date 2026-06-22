@extends('layouts.school')

@section('title', 'Staff Attendance')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Staff Attendance</h1>
                <p class="text-sm text-slate-500 mt-1">
                    @if(auth()->user()->isTeacher())
                        Your clock-in / clock-out history
                    @else
                        Track staff attendance and working hours
                    @endif
                </p>
            </div>
        </div>

        {{-- Clock In / Out Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0
                        {{ $todayRecord && $todayRecord->isClockedIn()
                            ? 'bg-emerald-50 shadow-lg shadow-emerald-500/10'
                            : ($todayRecord && $todayRecord->isClockedOut()
                                ? 'bg-blue-50 shadow-lg shadow-blue-500/10'
                                : 'bg-gray-100') }}">
                        @if($todayRecord && $todayRecord->isClockedIn())
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                        @elseif($todayRecord && $todayRecord->isClockedOut())
                            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">
                            @if($todayRecord && $todayRecord->isClockedIn())
                                Clocked In
                            @elseif($todayRecord && $todayRecord->isClockedOut())
                                Day Complete
                            @else
                                Not Clocked In
                            @endif
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">
                            @if($todayRecord && $todayRecord->clock_in_at)
                                In: {{ $todayRecord->formatted_clock_in }}
                                @if($todayRecord->clock_out_at)
                                    · Out: {{ $todayRecord->formatted_clock_out }} · {{ $todayRecord->formatted_duration }}
                                @endif
                            @else
                                {{ today()->format('D, M d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex gap-2">
                    @if(!$todayRecord || !$todayRecord->clock_in_at)
                        <form method="POST" action="{{ route('school.staff-attendance.clock-in') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                Clock In
                            </button>
                        </form>
                    @elseif($todayRecord && $todayRecord->isClockedIn())
                        <form method="POST" action="{{ route('school.staff-attendance.clock-out') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-red-600/20 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z"/></svg>
                                Clock Out
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        @if(auth()->user()->isTeacher())
            {{-- Teacher Stats --}}
            <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-indigo-500 flex items-center justify-center mb-3 shadow-lg shadow-brand-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $stats['total_days'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Total Days</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-2xl font-extrabold text-emerald-600">{{ $stats['present_days'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Completed Days</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-2xl font-extrabold text-amber-600">{{ $stats['avg_hours'] }}h</p>
                    <p class="text-xs text-slate-400 mt-0.5">Avg Hours/Day</p>
                </div>
            </div>
        @else
            {{-- Admin/Owner Today Summary --}}
            <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </div>
                    <p class="text-2xl font-extrabold text-emerald-600">{{ $todayStats['clocked_in'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Clocked In Now</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-2xl font-extrabold text-blue-600">{{ $todayStats['completed'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Completed Today</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-500">{{ $todayStats['not_clocked_in'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Not Clocked In</p>
                </div>
            </div>

            {{-- Staff Filter --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
                <form method="GET" class="flex flex-wrap gap-3">
                    <select name="user_id" class="flex-1 min-w-[160px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        <option value="">All Staff</option>
                        @foreach($staff as $member)
                        <option value="{{ $member->id }}" {{ request('user_id') == $member->id ? 'selected' : '' }}>{{ $member->full_name }} ({{ ucfirst($member->role) }})</option>
                        @endforeach
                    </select>
                    <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5H14.25M14.25 4.5V9m0-4.5H21M14.25 4.5L21 9M3 19.5h6.75M9.75 19.5V15m0 4.5H3M9.75 19.5L3 15"/></svg>
                        Filter
                    </button>
                    <a href="{{ route('school.staff-attendance.index') }}" class="px-4 py-2.5 text-slate-500 text-sm rounded-xl hover:bg-gray-100 transition">Clear</a>
                </form>
            </div>
        @endif

        {{-- Records Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            @if(!auth()->user()->isTeacher())
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Staff</th>
                            @endif
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Date</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Clock In</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Clock Out</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Duration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($records as $record)
                        <tr class="hover:bg-gray-50/50 transition">
                            @if(!auth()->user()->isTeacher())
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $record->user?->full_name ?? '—' }}</td>
                            @endif
                            <td class="py-3 px-4 text-slate-600">{{ $record->formatted_date }}</td>
                            <td class="py-3 px-4">
                                @if($record->clock_in_at)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $record->formatted_clock_in }}
                                    </span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($record->clock_out_at)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        {{ $record->formatted_clock_out }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-mono text-xs">{{ $record->formatted_duration }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isTeacher() ? '4' : '5' }}" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No attendance records found</p>
                                    <p class="text-xs text-slate-400 mt-1">Clock in to start tracking your attendance.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($records->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $records->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
