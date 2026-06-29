@extends('layouts.school')

@section('title', 'Dashboard')

@section('content')
    @php $isManager = auth()->user()->canManageSchool(); @endphp

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-800 p-6 sm:p-8 mb-8 animate-fade-up">
        <div class="absolute inset-0 opacity-50" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-400/15 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[11px] font-bold text-brand-200 bg-white/10 backdrop-blur-sm px-3 py-1 rounded-full border border-white/10">
                        {{ now()->format('l, F j, Y') }}
                    </span>
                    @if(auth()->user()->school?->currentTerm)
                    <span class="text-[11px] font-bold text-indigo-200 bg-indigo-400/20 backdrop-blur-sm px-3 py-1 rounded-full border border-indigo-300/20">
                        {{ auth()->user()->school->currentTerm->name }}
                    </span>
                    @endif
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Welcome back, {{ auth()->user()->first_name }}! 👋</h1>
                <p class="text-brand-200/80 mt-1 text-sm">
                    @if($isManager)
                        Here's an overview of your school management panel.
                    @elseif(auth()->user()->isStudent())
                        Here's your school overview at a glance.
                    @else
                        Here's an overview of your ward's progress.
                    @endif
                </p>
            </div>
            @if($isManager)
            <a href="{{ route('school.users.create') }}" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm text-white font-semibold px-5 py-2.5 rounded-xl border border-white/20 transition-all duration-200 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add User
            </a>
            @endif
        </div>
    </div>

    @if($isManager)
    {{-- ====== MANAGER DASHBOARD (Owner / Admin / Teacher) ====== --}}

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total Users --}}
        <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-400"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/25 stat-glow-blue">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-1 rounded-lg">
                    {{ $stats['teachers'] }}T · {{ $stats['students'] }}S
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['users'] }}</p>
            <p class="text-[11px] text-slate-400 mt-2">{{ $stats['teachers'] }} teachers, {{ $stats['students'] }} students</p>
        </div>

        {{-- Classes --}}
        <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/25 stat-glow-emerald">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                    {{ $stats['sections'] }} sections
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Classes</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['classes'] }}</p>
            <p class="text-[11px] text-slate-400 mt-2">Active class groups</p>
        </div>

        {{-- Revenue --}}
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25 stat-glow-amber">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9"/></svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">
                    {{ $stats['payments'] }} payments
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Revenue</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">&#8358;{{ number_format($stats['revenue']) }}</p>
            <p class="text-[11px] text-slate-400 mt-2">Collected this term</p>
        </div>

        {{-- Attendance --}}
        <div class="animate-fade-up delay-4 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25 stat-glow-purple">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @php $attColor = $stats['attendance_rate'] >= 75 ? 'text-emerald-600 bg-emerald-50' : ($stats['attendance_rate'] >= 50 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50'); @endphp
                <span class="inline-flex items-center gap-1 text-[10px] font-bold {{ $attColor }} px-2 py-1 rounded-lg">
                    {{ $stats['attendance_rate'] >= 75 ? 'Good' : ($stats['attendance_rate'] >= 50 ? 'Fair' : 'Low') }}
                </span>
            </div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Attendance</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['attendance_rate'] }}%</p>
            <div class="mt-3 w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-500 to-violet-400 rounded-full transition-all duration-500" style="width: {{ $stats['attendance_rate'] }}%"></div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8 animate-fade-up">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-slate-800">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('school.users.create') }}" class="group flex items-center gap-3 p-4 rounded-2xl border border-gray-100 hover:border-brand-200 hover:bg-brand-50/50 hover:shadow-md transition-all duration-200">
                <div class="w-11 h-11 bg-brand-50 group-hover:bg-brand-100 rounded-2xl flex items-center justify-center transition flex-shrink-0">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800">Add User</p>
                    <p class="text-[11px] text-slate-400">Teacher, student, etc.</p>
                </div>
            </a>
            <a href="{{ route('school.classes.create') }}" class="group flex items-center gap-3 p-4 rounded-2xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-md transition-all duration-200">
                <div class="w-11 h-11 bg-emerald-50 group-hover:bg-emerald-100 rounded-2xl flex items-center justify-center transition flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800">Add Class</p>
                    <p class="text-[11px] text-slate-400">Create new class group</p>
                </div>
            </a>
            <a href="{{ route('school.attendance.create') }}" class="group flex items-center gap-3 p-4 rounded-2xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50/50 hover:shadow-md transition-all duration-200">
                <div class="w-11 h-11 bg-amber-50 group-hover:bg-amber-100 rounded-2xl flex items-center justify-center transition flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800">Mark Attendance</p>
                    <p class="text-[11px] text-slate-400">Today's attendance</p>
                </div>
            </a>
            <a href="{{ route('school.payments.create') }}" class="group flex items-center gap-3 p-4 rounded-2xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 hover:shadow-md transition-all duration-200">
                <div class="w-11 h-11 bg-purple-50 group-hover:bg-purple-100 rounded-2xl flex items-center justify-center transition flex-shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800">Record Payment</p>
                    <p class="text-[11px] text-slate-400">Fee payment</p>
                </div>
            </a>
        </div>
    </div>

    {{-- ====== CHARTS SECTION ====== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Revenue Chart (2 cols) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-fade-up delay-1">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Revenue Overview</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Monthly fee collection (last 6 months)</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.5-5.75a.75.75 0 011.08 0l5.5 5.75a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd"/></svg>
                        Total: &#8358;{{ number_format(array_sum($chartData['revenue']['data'])) }}
                    </span>
                </div>
            </div>
            <div class="relative" style="height: 280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- User Distribution Doughnut --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-fade-up delay-2">
            <div class="mb-6">
                <h2 class="text-base font-bold text-slate-800">User Distribution</h2>
                <p class="text-xs text-slate-400 mt-0.5">Breakdown by role</p>
            </div>
            <div class="relative flex items-center justify-center" style="height: 200px;">
                <canvas id="userChart"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                        <span class="text-slate-600">Students</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $chartData['users']['students'] }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span class="text-slate-600">Teachers</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $chartData['users']['teachers'] }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span class="text-slate-600">Admins</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $chartData['users']['admins'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance + Enrollment Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Attendance Distribution --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-fade-up delay-3">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Attendance Distribution</h2>
                    <p class="text-xs text-slate-400 mt-0.5">All-time attendance breakdown</p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-purple-50 text-purple-600 border border-purple-100">
                    {{ $stats['attendance_rate'] }}% rate
                </span>
            </div>
            <div class="flex items-center gap-6">
                <div class="relative flex-shrink-0" style="width: 180px; height: 180px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
                <div class="flex-1 space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/50">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-sm font-medium text-slate-600">Present</span>
                        </div>
                        <span class="font-extrabold text-emerald-600">{{ $chartData['attendance']['present'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/50 border border-red-100/50">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-sm font-medium text-slate-600">Absent</span>
                        </div>
                        <span class="font-extrabold text-red-600">{{ $chartData['attendance']['absent'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50/50 border border-amber-100/50">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-sm font-medium text-slate-600">Late</span>
                        </div>
                        <span class="font-extrabold text-amber-600">{{ $chartData['attendance']['late'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Enrollment Trend --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-fade-up delay-4">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Enrollment Trend</h2>
                    <p class="text-xs text-slate-400 mt-0.5">New users per month</p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-brand-50 text-brand-600 border border-brand-100">
                    Total: {{ array_sum($chartData['enrollment']['data']) }}
                </span>
            </div>
            <div class="relative" style="height: 220px;">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Users --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-2">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Recent Users</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Latest additions to your school</p>
                </div>
                <a href="{{ route('school.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentUsers as $u)
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-brand-50/30 transition">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-100 to-indigo-100 flex items-center justify-center text-brand-600 font-bold text-xs flex-shrink-0">
                            {{ $u->initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $u->full_name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $u->email }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $u->role === 'teacher' ? 'bg-cyan-50 text-cyan-600' : ($u->role === 'student' ? 'bg-emerald-50 text-emerald-600' : ($u->role === 'admin' ? 'bg-brand-50 text-brand-600' : ($u->role === 'owner' ? 'bg-amber-50 text-amber-600' : 'bg-gray-50 text-gray-600'))) }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $u->role === 'teacher' ? 'bg-cyan-500' : ($u->role === 'student' ? 'bg-emerald-500' : ($u->role === 'admin' ? 'bg-brand-500' : ($u->role === 'owner' ? 'bg-amber-500' : 'bg-gray-500'))) }}"></span>
                            {{ ucfirst($u->role) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                        </div>
                        <p class="text-sm text-slate-400">No users yet</p>
                        <p class="text-xs text-slate-300 mt-1">Add your first user to get started</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-3">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Recent Payments</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Latest fee collections</p>
                </div>
                <a href="{{ route('school.payments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentPayments as $p)
                    <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-brand-50/30 transition">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $p->student?->full_name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $p->fee?->name ?? 'N/A' }} · {{ optional($p->paid_at)->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <span class="text-sm font-extrabold text-emerald-600">&#8358;{{ number_format($p->amount) }}</span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                        </div>
                        <p class="text-sm text-slate-400">No payments yet</p>
                        <p class="text-xs text-slate-300 mt-1">Record your first payment to see it here</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @else
    {{-- ====== STUDENT / PARENT DASHBOARD ====== --}}

    @if(auth()->user()->isParent() && $children->count() > 0)
    {{-- My Children Section --}}
    <div class="mb-8 animate-fade-up delay-1">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-800">My Children</h2>
            <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">{{ $children->count() }} {{ $children->count() > 1 ? 'wards' : 'ward' }}</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            @foreach($children as $child)
            <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-indigo-400"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-brand-500/25 text-white font-bold text-sm flex-shrink-0">
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
                            <div class="relative w-12 h-12">
                                <svg class="w-12 h-12 -rotate-90" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#f3f4f6" stroke-width="3"/>
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-dasharray="{{ ($childStats['rate'] / 100) * 100.53 }} 100.53" class="{{ $childStats['rate'] >= 75 ? 'text-emerald-500' : ($childStats['rate'] >= 50 ? 'text-amber-500' : 'text-red-500') }}"/>
                                </svg>
                                <span class="absolute inset-0 flex items-center justify-center text-[10px] font-extrabold {{ $childStats['rate'] >= 75 ? 'text-emerald-600' : ($childStats['rate'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">{{ $childStats['rate'] }}%</span>
                            </div>
                            <p class="text-[9px] text-slate-400 mt-1">attendance</p>
                        </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-3 gap-2 pt-3 border-t border-gray-100">
                        <a href="{{ route('school.attendance.index') }}?student={{ $child->id }}" class="flex flex-col items-center gap-1 p-2.5 rounded-xl hover:bg-purple-50 transition group">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 group-hover:bg-purple-100 flex items-center justify-center transition">
                                <svg class="w-4 h-4 text-purple-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-500">Attendance</span>
                        </a>
                        <a href="{{ route('school.grades.index') }}?student={{ $child->id }}" class="flex flex-col items-center gap-1 p-2.5 rounded-xl hover:bg-emerald-50 transition group">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 group-hover:bg-emerald-100 flex items-center justify-center transition">
                                <svg class="w-4 h-4 text-emerald-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-500">Grades</span>
                        </a>
                        <a href="{{ route('school.payments.index') }}?student={{ $child->id }}" class="flex flex-col items-center gap-1 p-2.5 rounded-xl hover:bg-amber-50 transition group">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center transition">
                                <svg class="w-4 h-4 text-amber-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                            </div>
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
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
        </div>
        <p class="text-sm font-medium text-slate-400">No children linked to your account yet</p>
        <p class="text-xs text-slate-300 mt-1">Please contact the school administrator to link your ward(s).</p>
    </div>
    @endif

    {{-- Parent School Updates --}}
    @if(auth()->user()->isParent())
    <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm mb-6">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">School Updates</h3>
                        <p class="text-xs text-slate-400">Announcements &amp; events</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Announcements</h4>
                        <a href="{{ route('school.announcements.index') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition">View all</a>
                    </div>
                    @forelse($recentAnnouncements as $announcement)
                    <div class="{{ !$loop->last ? 'border-b border-gray-50 pb-3 mb-3' : '' }}">
                        <div class="flex items-start gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-400 mt-1.5 flex-shrink-0"></span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $announcement->title }}</p>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->body), 80) }}</p>
                                <p class="text-[10px] text-slate-300 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-4 text-center"><p class="text-xs text-slate-400">No announcements</p></div>
                    @endforelse
                </div>
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Upcoming Events</h4>
                        <a href="{{ route('school.events.index') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition">View all</a>
                    </div>
                    @forelse($upcomingEvents as $event)
                    <div class="{{ !$loop->last ? 'border-b border-gray-50 pb-3 mb-3' : '' }}">
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 w-10 text-center">
                                <p class="text-[10px] font-bold uppercase text-slate-400">{{ $event->start_date->format('M') }}</p>
                                <p class="text-lg font-extrabold text-slate-700 leading-none">{{ $event->start_date->format('j') }}</p>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $event->title }}</p>
                                <span class="inline-flex items-center text-[10px] font-bold px-1.5 py-0.5 rounded {{ $event->type_color }}">{{ $event->type_label }}</span>
                                @if($event->location)
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $event->location }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-4 text-center"><p class="text-xs text-slate-400">No upcoming events</p></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Student Attendance Summary --}}
    @if(auth()->user()->isStudent() && $attendanceStats)
    <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm mb-6">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">My Attendance</h3>
                        <p class="text-xs text-slate-400">Overall tracking this term</p>
                    </div>
                </div>
                <a href="{{ route('school.attendance.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                    View All
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            {{-- Attendance Ring + Stats --}}
            <div class="flex flex-col sm:flex-row items-center gap-6">
                {{-- Circular Progress --}}
                <div class="relative w-32 h-32 flex-shrink-0">
                    <svg class="w-32 h-32 -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="52" fill="none" stroke="#f3f4f6" stroke-width="8"/>
                        <circle cx="60" cy="60" r="52" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-dasharray="{{ ($attendanceStats['rate'] / 100) * 326.73 }} 326.73" class="{{ $attendanceStats['rate'] >= 75 ? 'text-emerald-500' : ($attendanceStats['rate'] >= 50 ? 'text-amber-500' : 'text-red-500') }} transition-all duration-1000"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <p class="text-3xl font-extrabold {{ $attendanceStats['rate'] >= 75 ? 'text-emerald-600' : ($attendanceStats['rate'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">{{ $attendanceStats['rate'] }}%</p>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Rate</p>
                    </div>
                </div>

                {{-- Stat Breakdown --}}
                <div class="flex-1 grid grid-cols-3 gap-3 w-full">
                    <div class="text-center p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
                        <p class="text-2xl font-extrabold text-emerald-600">{{ $attendanceStats['present'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500 mt-1 uppercase tracking-wider">Present</p>
                    </div>
                    <div class="text-center p-4 rounded-2xl bg-red-50 border border-red-100">
                        <p class="text-2xl font-extrabold text-red-600">{{ $attendanceStats['absent'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500 mt-1 uppercase tracking-wider">Absent</p>
                    </div>
                    <div class="text-center p-4 rounded-2xl bg-amber-50 border border-amber-100">
                        <p class="text-2xl font-extrabold text-amber-600">{{ $attendanceStats['late'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500 mt-1 uppercase tracking-wider">Late</p>
                    </div>
                </div>
            </div>

            @if($attendanceStats['last_status'])
            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
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

    {{-- ===== STUDENT DASHBOARD WIDGETS ===== --}}
    @if(auth()->user()->isStudent())

    {{-- Grade Performance Summary + Pending Homework --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Grade Performance Summary (2 cols) --}}
        <div class="lg:col-span-2 animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Grade Performance</h3>
                            <p class="text-xs text-slate-400">{{ $gradeSummary ? $gradeSummary['term_name'] : 'Current term' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('school.grades.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                        View All
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                @if($gradeSummary)
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    {{-- Average Score + Grade Badge --}}
                    <div class="flex-shrink-0 text-center">
                        <div class="relative w-24 h-24 mx-auto">
                            <svg class="w-24 h-24 -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="42" fill="none" stroke="#f3f4f6" stroke-width="6"/>
                                <circle cx="50" cy="50" r="42" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" stroke-dasharray="{{ ($gradeSummary['average'] / 100) * 263.89 }} 263.89" class="{{ $gradeSummary['average'] >= 70 ? 'text-emerald-500' : ($gradeSummary['average'] >= 50 ? 'text-amber-500' : 'text-red-500') }} transition-all duration-1000"/>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <p class="text-2xl font-extrabold {{ $gradeSummary['average'] >= 70 ? 'text-emerald-600' : ($gradeSummary['average'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">{{ $gradeSummary['average'] }}</p>
                                <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Average</p>
                            </div>
                        </div>
                        @php $gradeColor = ['A' => 'bg-emerald-100 text-emerald-700', 'B' => 'bg-blue-100 text-blue-700', 'C' => 'bg-amber-100 text-amber-700', 'D' => 'bg-orange-100 text-orange-700', 'E' => 'bg-orange-100 text-orange-700', 'F' => 'bg-red-100 text-red-700'][$gradeSummary['overall_grade']] ?? 'bg-gray-100 text-gray-700'; @endphp
                        <span class="inline-flex items-center gap-1 mt-2 text-xs font-bold px-3 py-1 rounded-full {{ $gradeColor }}">
                            Grade {{ $gradeSummary['overall_grade'] }}
                        </span>
                    </div>

                    {{-- Mini Bar Chart --}}
                    <div class="flex-1 w-full overflow-x-auto">
                        <div class="flex items-end justify-between gap-1.5 min-w-[200px]" style="height: 120px;">
                            @foreach($gradeSummary['grades'] as $grade)
                            @php $barHeight = max(8, ($grade->total_score / 100) * 100); @endphp
                            <div class="flex-1 flex flex-col items-center gap-1.5 group min-w-[24px]">
                                <div class="w-full flex flex-col justify-end h-[100px]">
                                    <div class="w-full rounded-t-md transition-all duration-500 group-hover:opacity-80 {{ $grade->total_score >= 70 ? 'bg-emerald-400' : ($grade->total_score >= 50 ? 'bg-amber-400' : 'bg-red-400') }}" style="height: {{ $barHeight }}%;">
                                        <span class="opacity-0 group-hover:opacity-100 transition-opacity text-[9px] font-bold text-white text-center block pt-0.5">{{ $grade->total_score }}</span>
                                    </div>
                                </div>
                                <span class="text-[9px] text-slate-400 truncate max-w-[60px]">{{ \Illuminate\Support\Str::limit($grade->subject?->name ?? 'N/A', 8) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-slate-400">{{ $gradeSummary['subject_count'] }} subjects</span>
                            <span class="text-xs font-semibold text-slate-600">Total: {{ number_format((float)$gradeSummary['total_score'], 0) }}</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="py-8 text-center">
                    <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                    </div>
                    <p class="text-sm text-slate-400">No grades published for this term yet</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Pending Homework --}}
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-indigo-400"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-500 flex items-center justify-center shadow-lg shadow-brand-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Pending Homework</h3>
                            <p class="text-xs text-slate-400">Open assignments</p>
                        </div>
                    </div>
                    <a href="{{ route('school.homework.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                        View All
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                @forelse($pendingHomework as $hw)
                    @php $submission = $hw->submissions->first(); @endphp
                    <div class="flex items-center gap-3 py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $hw->title }}</p>
                            <p class="text-xs text-slate-400">{{ $hw->subject?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            @if($hw->isOverdue() && !$submission)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full bg-red-50 text-red-600 border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Overdue
                                </span>
                            @elseif($submission?->isGraded())
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Graded
                                </span>
                            @elseif($submission?->isSubmitted())
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Submitted
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @endif
                            <p class="text-[10px] text-slate-400 mt-1">Due {{ $hw->due_date->format('M d') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm text-slate-400">No pending homework</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Upcoming Exams + School Updates --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Upcoming Exams --}}
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-400"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center shadow-lg shadow-red-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Upcoming Exams</h3>
                            <p class="text-xs text-slate-400">Exam timetable</p>
                        </div>
                    </div>
                    <a href="{{ route('school.exams.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                        View All
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>

                @forelse($upcomingExams as $exam)
                    <div class="{{ !$loop->last ? 'border-b border-gray-50' : '' }} py-3">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-bold text-slate-800">{{ $exam->name }}</p>
                            <span class="text-[10px] font-semibold text-slate-400">{{ $exam->formatted_date }}</span>
                        </div>
                        @if($exam->schedules->isNotEmpty())
                        <div class="space-y-1.5">
                            @foreach($exam->schedules->take(3) as $schedule)
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-400 flex-shrink-0"></span>
                                <span class="font-medium text-slate-700">{{ $schedule->subject?->name ?? 'N/A' }}</span>
                                <span class="text-slate-400">{{ $schedule->date?->format('M d') }}</span>
                                @if($schedule->start_time)
                                <span class="text-slate-400">{{ $schedule->start_time->format('g:i A') }}</span>
                                @endif
                                @if($schedule->room)
                                <span class="text-slate-400 ml-auto truncate">{{ $schedule->room }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="py-6 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm text-slate-400">No upcoming exams</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- School Updates: Announcements + Events (2 cols) --}}
        <div class="lg:col-span-2 animate-fade-up delay-4 relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">School Updates</h3>
                            <p class="text-xs text-slate-400">Announcements &amp; events</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Announcements --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Announcements</h4>
                            <a href="{{ route('school.announcements.index') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition">View all</a>
                        </div>
                        @forelse($recentAnnouncements as $announcement)
                        <div class="{{ !$loop->last ? 'border-b border-gray-50 pb-3 mb-3' : '' }}">
                            <div class="flex items-start gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-400 mt-1.5 flex-shrink-0"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $announcement->title }}</p>
                                    <p class="text-xs text-slate-400 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->body), 80) }}</p>
                                    <p class="text-[10px] text-slate-300 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-4 text-center">
                            <p class="text-xs text-slate-400">No announcements</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Events --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Upcoming Events</h4>
                            <a href="{{ route('school.events.index') }}" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 transition">View all</a>
                        </div>
                        @forelse($upcomingEvents as $event)
                        <div class="{{ !$loop->last ? 'border-b border-gray-50 pb-3 mb-3' : '' }}">
                            <div class="flex items-start gap-2">
                                <div class="flex-shrink-0 w-10 text-center">
                                    <p class="text-[10px] font-bold uppercase text-slate-400">{{ $event->start_date->format('M') }}</p>
                                    <p class="text-lg font-extrabold text-slate-700 leading-none">{{ $event->start_date->format('j') }}</p>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $event->title }}</p>
                                    <span class="inline-flex items-center text-[10px] font-bold px-1.5 py-0.5 rounded {{ $event->type_color }}">{{ $event->type_label }}</span>
                                    @if($event->location)
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $event->location }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-4 text-center">
                            <p class="text-xs text-slate-400">No upcoming events</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

    {{-- Quick Access Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @if(auth()->user()->isStudent())
        <a href="{{ route('school.attendance.index') }}" class="group animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="font-bold text-slate-800">My Attendance</p>
            <p class="text-sm text-slate-400 mt-1">View attendance records</p>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-purple-600 mt-3 group-hover:gap-2 transition-all">
                View records
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </span>
        </a>
        @endif

        <a href="{{ route('school.grades.index') }}" class="group animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
            </div>
            <p class="font-bold text-slate-800">{{ auth()->user()->isStudent() ? 'My Grades' : "Ward's Grades" }}</p>
            <p class="text-sm text-slate-400 mt-1">View results and scores</p>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 mt-3 group-hover:gap-2 transition-all">
                View results
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </span>
        </a>

        <a href="{{ route('school.payments.index') }}" class="group animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
            </div>
            <p class="font-bold text-slate-800">{{ auth()->user()->isStudent() ? 'My Payments' : 'Payments' }}</p>
            <p class="text-sm text-slate-400 mt-1">View payment history</p>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 mt-3 group-hover:gap-2 transition-all">
                View history
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </span>
        </a>
    </div>
    @endif
@endsection

@push('scripts')
@if($isManager && isset($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Global Chart Defaults =====
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#94a3b8';

        // ===== Revenue Chart (Line) =====
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const gradient = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($chartData['revenue']['labels']),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($chartData['revenue']['data']),
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { weight: 'bold', size: 12 },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(ctx) {
                                    return '\u20A6' + ctx.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: {
                                callback: function(v) { return '\u20A6' + (v / 1000) + 'k'; },
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // ===== User Distribution (Doughnut) =====
        const userCtx = document.getElementById('userChart');
        if (userCtx) {
            new Chart(userCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Students', 'Teachers', 'Admins'],
                    datasets: [{
                        data: @json(array_values($chartData['users'])),
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        }

        // ===== Attendance Distribution (Doughnut) =====
        const attCtx = document.getElementById('attendanceChart');
        if (attCtx) {
            new Chart(attCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Present', 'Absent', 'Late'],
                    datasets: [{
                        data: @json(array_values($chartData['attendance'])),
                        backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        }

        // ===== Enrollment Trend (Bar) =====
        const enrollCtx = document.getElementById('enrollmentChart');
        if (enrollCtx) {
            new Chart(enrollCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['enrollment']['labels']),
                    datasets: [{
                        label: 'New Users',
                        data: @json($chartData['enrollment']['data']),
                        backgroundColor: function(ctx) {
                            const chart = ctx.chart;
                            const { ctx: canvasCtx, chartArea } = chart;
                            if (!chartArea) return 'rgba(37, 99, 235, 0.6)';
                            const gradient = canvasCtx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.7)');
                            gradient.addColorStop(1, 'rgba(96, 165, 250, 0.2)');
                            return gradient;
                        },
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 'flex',
                        maxBarThickness: 50,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.parsed.y + (ctx.parsed.y === 1 ? ' user' : ' users');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: {
                                stepSize: 1,
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endpush
