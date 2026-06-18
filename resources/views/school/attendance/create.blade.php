@extends('layouts.school')

@section('title', 'Mark Attendance')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.attendance.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Attendance
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Mark Attendance</h1>
            <p class="text-sm text-slate-400 mt-0.5">Record daily student attendance</p>
        </div>

        <form id="attendance-form" method="GET" action="{{ route('school.attendance.create') }}">
        </form>

        <form method="POST" action="{{ route('school.attendance.store') }}">
            @csrf
            <input type="hidden" name="class_id" id="post_class_id" value="{{ $selectedClass->id ?? '' }}">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                        <select id="class_id" name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" form="attendance-form" onchange="document.getElementById('attendance-form').submit()">
                            <option value="">Select Class</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ ($selectedClass->id ?? null) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-semibold text-slate-700 mb-1.5">Date</label>
                        <input type="date" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    </div>
                </div>
            </div>

            @php
                $hasStudents = $sectionGroups->isNotEmpty() || $unassignedStudents->isNotEmpty();
            @endphp

            @if($selectedClass && $hasStudents)
                @foreach($sectionGroups as $group)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
                    <div class="bg-gray-50/50 px-4 py-2.5 border-b border-gray-100 flex items-center gap-2">
                        <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">{{ $group['section']->name }}</span>
                        <span class="text-xs text-slate-400">{{ $group['students']->count() }} student{{ $group['students']->count() !== 1 ? 's' : '' }}</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs w-10">#</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Student Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group['students'] as $student)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                    <td class="py-3 px-4 text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 font-medium text-slate-800">{{ $student->full_name }}</td>
                                    <td class="py-3 px-4">
                                        <input type="hidden" name="attendance[{{ $loop->parent->index }}_{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                        <select name="attendance[{{ $loop->parent->index }}_{{ $loop->index }}][status]" class="px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                            <option value="present" selected>Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="late">Late</option>
                                            <option value="excused">Excused</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach

                @if($unassignedStudents->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
                    <div class="bg-gray-50/50 px-4 py-2.5 border-b border-gray-100 flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-600 bg-gray-100 px-2 py-0.5 rounded-full">Unassigned Section</span>
                        <span class="text-xs text-slate-400">{{ $unassignedStudents->count() }} student{{ $unassignedStudents->count() !== 1 ? 's' : '' }}</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs w-10">#</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Student Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unassignedStudents as $student)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                    <td class="py-3 px-4 text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 font-medium text-slate-800">{{ $student->full_name }}</td>
                                    <td class="py-3 px-4">
                                        <input type="hidden" name="attendance[u_{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                        <select name="attendance[u_{{ $loop->index }}][status]" class="px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                            <option value="present" selected>Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="late">Late</option>
                                            <option value="excused">Excused</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Save Attendance
                    </button>
                    <button type="button" id="markAllPresent" class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mark All Present
                    </button>
                </div>
            @elseif($selectedClass)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-400 mb-1">No students in this class yet</p>
                    <p class="text-xs text-slate-400 mb-4">Add students to <strong>{{ $selectedClass->name }}</strong> so you can mark their attendance.</p>
                    <a href="{{ route('school.users.create') }}?class_id={{ $selectedClass->id }}&role=student" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-brand-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Add Students
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                    <p class="text-slate-400 text-sm">Select a class above to mark attendance.</p>
                </div>
            @endif
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('markAllPresent')?.addEventListener('click', function() {
            document.querySelectorAll('select[name$="[status]"]').forEach(sel => sel.value = 'present');
        });

        const classSelect = document.getElementById('class_id');
        const postClassId = document.getElementById('post_class_id');
        if (classSelect && postClassId) {
            classSelect.addEventListener('change', function() {
                postClassId.value = this.value;
            });
        }
    </script>
    @endpush
@endsection
