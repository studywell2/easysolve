@extends('layouts.school')

@section('title', $class->name)

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.classes.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Classes
        </a>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-extrabold text-slate-900">{{ $class->name }}</h1>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full {{ $class->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $class->status === 'active' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            {{ ucfirst($class->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $class->description ?: 'No description' }}</p>
                </div>
            </div>
            <a href="{{ route('school.classes.edit', $class) }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                Edit Class
            </a>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-400"></div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sections</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $class->sections->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Students</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $class->students->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</p>
                        <p class="text-lg font-bold text-slate-800">{{ ucfirst($class->status) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sections -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-bold text-slate-800 mb-4">Sections</h2>
            @if($class->sections->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($class->sections as $section)
                <div class="p-4 rounded-xl border border-gray-100 hover:border-brand-300 hover:shadow-sm transition">
                    <p class="font-semibold text-slate-800">{{ $class->name }}{{ $section->name }}</p>
                    <p class="text-sm text-slate-500 mt-1">Capacity: {{ $section->capacity }}</p>
                    <p class="text-sm text-slate-500">Students: {{ $section->students->count() }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-slate-400 text-sm text-center py-4">No sections configured.</p>
            @endif
        </div>

        <!-- Students -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-800">Students</h2>
                <a href="{{ route('school.users.create') }}?role=student" class="text-sm text-brand-600 hover:text-brand-700 font-semibold transition">+ Add Student</a>
            </div>
            @if($class->students->count())
            <div class="divide-y divide-gray-50">
                @foreach($class->students as $student)
                <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-brand-50/30 transition">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-100 to-indigo-100 flex items-center justify-center text-brand-600 font-bold text-xs flex-shrink-0">
                        {{ $student->initials }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $student->full_name }}</p>
                        <p class="text-xs text-slate-400">{{ $student->section?->name ? $class->name . $student->section->name : '' }}</p>
                    </div>
                    <a href="{{ route('school.users.show', $student) }}" class="text-xs text-brand-600 hover:text-brand-700 font-semibold transition">View</a>
                </div>
                @endforeach
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm text-slate-400">No students assigned yet</p>
            </div>
            @endif
        </div>
    </div>
@endsection