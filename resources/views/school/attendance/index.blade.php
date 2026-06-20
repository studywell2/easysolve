@extends('layouts.school')

@section('title', 'Attendance')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    @if($viewingStudent && auth()->user()->isParent())
                        {{ $viewingStudent->full_name }}'s Attendance
                    @else
                        Attendance Records
                    @endif
                </h1>
                <p class="text-sm text-slate-500 mt-1">Track and manage student attendance</p>
            </div>
            @if(auth()->user()->canManageSchool())
            <a href="{{ route('school.attendance.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Mark Attendance
            </a>
            @endif
        </div>

        {{-- Parent child selector --}}
        @if(auth()->user()->isParent() && $children->count() > 1)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-medium text-slate-600">Viewing:</span>
                @foreach($children as $child)
                <a href="{{ route('school.attendance.index') }}?student={{ $child->id }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium transition {{ ($viewingStudent?->id ?? null) == $child->id ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $child->full_name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if(auth()->user()->isParent() && $children->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-400">No children linked to your account yet</p>
            <p class="text-xs text-slate-400 mt-1">Please contact the school administrator to link your ward(s).</p>
        </div>
        @else

        {{-- Summary Stats --}}
        @if($summary)
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center mb-3 shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-slate-800">{{ $summary['rate'] }}%</p>
                <p class="text-xs text-slate-400 mt-0.5">Attendance Rate</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-emerald-600">{{ $summary['present'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Present</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-red-600">{{ $summary['absent'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Absent</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-2xl font-extrabold text-amber-600">{{ $summary['late'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">Late / Excused</p>
            </div>
        </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                @if(auth()->user()->canManageSchool())
                <select name="class_id" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Classes</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @endif

                <input type="date" name="date" value="{{ request('date') }}" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">

                <select name="status" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Statuses</option>
                    <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                    <option value="excused" {{ request('status') == 'excused' ? 'selected' : '' }}>Excused</option>
                </select>

                @if($viewingStudent)
                <input type="hidden" name="student" value="{{ $viewingStudent->id }}">
                @endif

                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5H14.25M14.25 4.5V9m0-4.5H21M14.25 4.5L21 9M3 19.5h6.75M9.75 19.5V15m0 4.5H3M9.75 19.5L3 15"/></svg>
                    Filter
                </button>
                <a href="{{ route('school.attendance.index') }}{{ $viewingStudent ? '?student='.$viewingStudent->id : '' }}" class="px-4 py-2.5 text-slate-500 text-sm rounded-xl hover:bg-gray-100 transition">Clear</a>
            </form>
        </div>

        {{-- Attendance Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            @if(auth()->user()->canManageSchool() || auth()->user()->isParent())
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Student</th>
                            @endif
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Class</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Date</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                            @if(auth()->user()->canManageSchool())
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Marked By</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($attendances as $a)
                        <tr class="hover:bg-gray-50/50 transition">
                            @if(auth()->user()->canManageSchool() || auth()->user()->isParent())
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $a->student?->full_name ?? '—' }}</td>
                            @endif
                            <td class="py-3 px-4 text-slate-600">{{ $a->schoolClass?->name ?? '—' }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $a->date->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full {{ $a->status === 'present' ? 'bg-emerald-100 text-emerald-700' : ($a->status === 'absent' ? 'bg-red-100 text-red-700' : ($a->status === 'late' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700')) }}">
                                    @if($a->status === 'present')
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    @elseif($a->status === 'absent')
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    @elseif($a->status === 'late')
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    @endif
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            @if(auth()->user()->canManageSchool())
                            <td class="py-3 px-4 text-slate-400 text-xs">{{ $a->marker?->full_name ?? '—' }}</td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->canManageSchool() ? '5' : (auth()->user()->isParent() ? '4' : '3') }}" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No attendance records found</p>
                                    <p class="text-xs text-slate-400 mt-1">Try adjusting your filters or mark attendance for a class.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendances->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $attendances->withQueryString()->links() }}</div>
            @endif
        </div>

        @endif
    </div>
@endsection
