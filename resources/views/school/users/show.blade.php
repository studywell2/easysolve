@extends('layouts.school')

@section('title', $user->full_name . ' — User Details')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Users
        </a>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-brand-500/20">
                    {{ $user->initials }}
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">{{ $user->full_name }}</h1>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>
            <a href="{{ route('school.users.edit', $user) }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                Edit User
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Info -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-slate-800">Profile Information</h2>
                </div>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Full Name</dt>
                        <dd class="text-sm font-semibold text-slate-800 mt-0.5">{{ $user->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</dt>
                        <dd class="text-sm font-semibold text-slate-800 mt-0.5">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</dt>
                        <dd class="mt-0.5">
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full {{ $user->role === 'teacher' ? 'bg-blue-50 text-blue-600' : ($user->role === 'student' ? 'bg-emerald-50 text-emerald-600' : ($user->role === 'admin' ? 'bg-purple-50 text-purple-600' : ($user->role === 'owner' ? 'bg-amber-50 text-amber-600' : 'bg-gray-100 text-gray-700'))) }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'teacher' ? 'bg-blue-500' : ($user->role === 'student' ? 'bg-emerald-500' : ($user->role === 'admin' ? 'bg-purple-500' : ($user->role === 'owner' ? 'bg-amber-500' : 'bg-gray-400'))) }}"></span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</dt>
                        <dd class="mt-0.5">
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full {{ $user->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    @if($user->class)
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Class</dt>
                        <dd class="text-sm font-semibold text-slate-800 mt-0.5">{{ $user->class->name }}</dd>
                    </div>
                    @endif
                    @if($user->section)
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Section</dt>
                        <dd class="text-sm font-semibold text-slate-800 mt-0.5">{{ $user->section->name }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Member Since</dt>
                        <dd class="text-sm font-semibold text-slate-800 mt-0.5">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Attendance Summary -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-slate-800">Attendance Summary</h2>
                </div>
                @php
                    $total = $user->attendance_records->count();
                    $present = $user->attendance_records->where('status', 'present')->count();
                    $absent = $user->attendance_records->where('status', 'absent')->count();
                    $late = $user->attendance_records->where('status', 'late')->count();
                @endphp
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-xl">
                        <span class="text-sm font-medium text-slate-600">Total Records</span>
                        <span class="text-sm font-bold text-slate-800">{{ $total }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-emerald-50/50 rounded-xl">
                        <span class="text-sm font-medium text-emerald-600">Present</span>
                        <span class="text-sm font-bold text-emerald-700">{{ $present }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-xl">
                        <span class="text-sm font-medium text-red-600">Absent</span>
                        <span class="text-sm font-bold text-red-700">{{ $absent }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-amber-50/50 rounded-xl">
                        <span class="text-sm font-medium text-amber-600">Late</span>
                        <span class="text-sm font-bold text-amber-700">{{ $late }}</span>
                    </div>
                    @if($total > 0)
                    <div class="flex items-center justify-between p-3 bg-brand-50/50 rounded-xl">
                        <span class="text-sm font-medium text-brand-600">Attendance Rate</span>
                        <span class="text-sm font-extrabold text-brand-700">{{ round(($present / $total) * 100) }}%</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Grades -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-slate-800">Grades</h2>
                </div>
                @if($user->grades && $user->grades->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->grades as $grade)
                        <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-xl">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $grade->subject?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ $grade->term?->name ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-slate-800">{{ $grade->score }}</span>
                                @if($grade->grade)
                                    <span class="text-xs text-slate-400 ml-1">({{ $grade->grade }})</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                        </div>
                        <p class="text-sm text-slate-400">No grades recorded yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
