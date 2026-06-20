@extends('layouts.school')

@section('title', 'Dashboard')

@section('content')
    @php $isManager = auth()->user()->canManageSchool(); @endphp

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-800 p-6 sm:p-8 mb-8 animate-fade-up">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNCI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-400/15 rounded-full blur-3xl"></div>
        <div class="relative">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Welcome back, {{ auth()->user()->first_name }}! 👋</h1>
            @if($isManager)
                <p class="text-brand-200/80 mt-1 text-sm">Here's an overview of your school management panel.</p>
            @else
                <p class="text-brand-200/80 mt-1 text-sm">Your school overview at a glance.</p>
            @endif
        </div>
    </div>

    @if($isManager)
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Total Users -->
        <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['users'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $stats['teachers'] }} teachers, {{ $stats['students'] }} students</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/25 stat-glow-blue">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Classes -->
        <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Classes</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['classes'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $stats['sections'] }} sections</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/25 stat-glow-emerald">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Revenue</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">₦{{ number_format($stats['revenue']) }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $stats['payments'] }} payments this term</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25 stat-glow-amber">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="animate-fade-up delay-4 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Attendance</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['attendance_rate'] }}%</p>
                    <p class="text-xs text-slate-400 mt-1">Average this term</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25 stat-glow-purple">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8 animate-fade-up">
        <h2 class="text-base font-bold text-slate-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('school.users.create') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-brand-200 hover:bg-brand-50/50 transition-all duration-200">
                <div class="w-10 h-10 bg-brand-50 group-hover:bg-brand-100 rounded-xl flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Add User</p>
                    <p class="text-xs text-slate-400">Teacher, student, etc.</p>
                </div>
            </a>

            <a href="{{ route('school.classes.create') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-200">
                <div class="w-10 h-10 bg-emerald-50 group-hover:bg-emerald-100 rounded-xl flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Add Class</p>
                    <p class="text-xs text-slate-400">Create new class group</p>
                </div>
            </a>

            <a href="{{ route('school.attendance.create') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50/50 transition-all duration-200">
                <div class="w-10 h-10 bg-amber-50 group-hover:bg-amber-100 rounded-xl flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Mark Attendance</p>
                    <p class="text-xs text-slate-400">Today's attendance</p>
                </div>
            </a>

            <a href="{{ route('school.payments.create') }}" class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 transition-all duration-200">
                <div class="w-10 h-10 bg-purple-50 group-hover:bg-purple-100 rounded-xl flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Record Payment</p>
                    <p class="text-xs text-slate-400">Fee payment</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-2">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-slate-800">Recent Users</h2>
                <a href="{{ route('school.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentUsers as $u)
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-brand-50/30 transition">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-100 to-indigo-100 flex items-center justify-center text-brand-600 font-bold text-xs flex-shrink-0">
                            {{ $u->initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $u->full_name }}</p>
                            <p class="text-xs text-slate-400">{{ $u->email }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $u->role === 'teacher' ? 'bg-blue-50 text-blue-600' : ($u->role === 'student' ? 'bg-emerald-50 text-emerald-600' : ($u->role === 'admin' ? 'bg-purple-50 text-purple-600' : ($u->role === 'owner' ? 'bg-amber-50 text-amber-600' : 'bg-gray-50 text-gray-600'))) }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $u->role === 'teacher' ? 'bg-blue-500' : ($u->role === 'student' ? 'bg-emerald-500' : ($u->role === 'admin' ? 'bg-purple-500' : ($u->role === 'owner' ? 'bg-amber-500' : 'bg-gray-500'))) }}"></span>
                            {{ ucfirst($u->role) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <p class="text-sm text-slate-400">No users yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-3">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-slate-800">Recent Payments</h2>
                <a href="{{ route('school.payments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentPayments as $p)
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-brand-50/30 transition">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $p->student?->full_name ?? 'N/A' }} — {{ $p->fee?->name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-400">{{ optional($p->paid_at)->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <span class="text-sm font-bold text-emerald-600">₦{{ number_format($p->amount) }}</span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <p class="text-sm text-slate-400">No payments yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @else
    <!-- Student / Parent Dashboard -->

    @if(auth()->user()->isParent() && $children->count() > 0)
    <!-- My Children Section -->
    <div class="mb-8 animate-fade-up delay-1">
        <h2 class="text-lg font-bold text-slate-800 mb-4">My Children</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            @foreach($children as $child)
            <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-indigo-400"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-brand-500/25 text-white font-bold text-sm">
                            {{ $child->initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-slate-800 truncate">{{ $child->full_name }}</p>
                            <p class="text-sm text-slate-400">
                                @if($child->schoolClass)
                                    {{ $child->schoolClass->name }}
                                    @if($child->section) — {{ $child->section->name }}@endif
                                @else
                                    No class assigned
                                @endif
                            </p>
                        </div>
                        @php $childStats = $childAttendanceStats[$child->id] ?? null; @endphp
                        @if($childStats && $childStats['total'] > 0)
                        <div class="text-right flex-shrink-0">
                            <p class="text-lg font-extrabold {{ $childStats['rate'] >= 75 ? 'text-emerald-600' : ($childStats['rate'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">{{ $childStats['rate'] }}%</p>
                            <p class="text-[10px] text-slate-400">attendance</p>
                        </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-3 gap-2 pt-3 border-t border-gray-100">
                        <a href="{{ route('school.attendance.index') }}?student={{ $child->id }}" class="flex flex-col items-center gap-1 p-2 rounded-xl hover:bg-purple-50 transition group">
                            <svg class="w-4 h-4 text-purple-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[10px] font-semibold text-slate-500">Attendance</span>
                        </a>
                        <a href="{{ route('school.grades.index') }}?student={{ $child->id }}" class="flex flex-col items-center gap-1 p-2 rounded-xl hover:bg-emerald-50 transition group">
                            <svg class="w-4 h-4 text-emerald-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                            <span class="text-[10px] font-semibold text-slate-500">Grades</span>
                        </a>
                        <a href="{{ route('school.payments.index') }}?student={{ $child->id }}" class="flex flex-col items-center gap-1 p-2 rounded-xl hover:bg-amber-50 transition group">
                            <svg class="w-4 h-4 text-amber-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                            <span class="text-[10px] font-semibold text-slate-500">Payments</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @elseif(auth()->user()->isParent())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8 text-center animate-fade-up">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
        </div>
        <p class="text-sm font-medium text-slate-400">No children linked to your account yet</p>
        <p class="text-xs text-slate-300 mt-1">Please contact the school administrator to link your ward(s).</p>
    </div>
    @endif

    {{-- Student Attendance Summary Card --}}
    @if(auth()->user()->isStudent() && $attendanceStats)
    <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm mb-6">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">My Attendance</h3>
                        <p class="text-xs text-slate-400">Overall tracking</p>
                    </div>
                </div>
                <a href="{{ route('school.attendance.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition">View All →</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                <div class="text-center">
                    <p class="text-2xl font-extrabold {{ $attendanceStats['rate'] >= 75 ? 'text-emerald-600' : ($attendanceStats['rate'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">{{ $attendanceStats['rate'] }}%</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Rate</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-extrabold text-emerald-600">{{ $attendanceStats['present'] }}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Present</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-extrabold text-red-600">{{ $attendanceStats['absent'] }}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Absent</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-extrabold text-amber-600">{{ $attendanceStats['late'] }}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Late</p>
                </div>
            </div>
            @if($attendanceStats['last_status'])
            <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-2">
                <span class="text-xs text-slate-400">Last recorded:</span>
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full {{ $attendanceStats['last_status'] === 'present' ? 'bg-emerald-100 text-emerald-700' : ($attendanceStats['last_status'] === 'absent' ? 'bg-red-100 text-red-700' : ($attendanceStats['last_status'] === 'late' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700')) }}">
                    {{ ucfirst($attendanceStats['last_status']) }}
                </span>
                <span class="text-xs text-slate-400">{{ $attendanceStats['last_date'] }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Parent: show attendance rate per child in children cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @if(auth()->user()->isStudent())
        <a href="{{ route('school.attendance.index') }}" class="group animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="font-bold text-slate-800">My Attendance</p>
            <p class="text-sm text-slate-400 mt-1">View attendance records</p>
        </a>
        @endif

        <a href="{{ route('school.grades.index') }}" class="group animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
            </div>
            <p class="font-bold text-slate-800">{{ auth()->user()->isStudent() ? 'My Grades' : "Ward's Grades" }}</p>
            <p class="text-sm text-slate-400 mt-1">View results and scores</p>
        </a>

        <a href="{{ route('school.payments.index') }}" class="group animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
            </div>
            <p class="font-bold text-slate-800">{{ auth()->user()->isStudent() ? 'My Payments' : 'Payments' }}</p>
            <p class="text-sm text-slate-400 mt-1">View payment history</p>
        </a>
    </div>
    @endif
@endsection