@extends('layouts.school')

@section('title', 'Bulk Grade Entry')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.grades.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Grades
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Bulk Grade Entry</h1>
            <p class="text-sm text-slate-400 mt-0.5">Enter scores for all students at once</p>
        </div>

        {{-- Selection Filters --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('school.grades.bulk') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Class</label>
                    <select name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        <option value="">Select Class</option>
                        @foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Subject</label>
                    <select name="subject_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $s)<option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Term</label>
                    <select name="term_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        <option value="">Select Term</option>
                        @foreach($terms as $t)<option value="{{ $t->id }}" {{ request('term_id') == $t->id ? 'selected' : '' }}>{{ $t->academicSession->name }} - {{ $t->name }}</option>@endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Load Students
                    </button>
                </div>
            </form>
        </div>

        @if($students->isNotEmpty())
        <form method="POST" action="{{ route('school.grades.bulk.store') }}">
            @csrf
            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
            <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
            <input type="hidden" name="term_id" value="{{ request('term_id') }}">

            {{-- Info Bar --}}
            <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 text-brand-700 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        {{ $students->count() }} Students
                    </span>
                    <span class="text-xs">CA max 40 · Exam max 60 · Total = 100</span>
                </div>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Save All Grades
                </button>
            </div>

            {{-- Grade Entry Grid --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full data-table">
                        <thead>
                            <tr>
                                <th class="text-left px-5 py-3.5">#</th>
                                <th class="text-left px-5 py-3.5">Student</th>
                                <th class="text-center px-5 py-3.5">CA Score (40)</th>
                                <th class="text-center px-5 py-3.5">Exam Score (60)</th>
                                <th class="text-center px-5 py-3.5">Total</th>
                                <th class="text-center px-5 py-3.5">Grade</th>
                                <th class="text-left px-5 py-3.5">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($students as $index => $student)
                                @php
                                    $existing = $existingGrades->get($student->id);
                                    $ca = $existing?->ca_score;
                                    $exam = $existing?->exam_score;
                                    $total = $existing?->total_score;
                                    $grade = $existing?->grade;
                                @endphp
                                <tr class="grade-row">
                                    <td class="px-5 py-3 text-xs text-slate-400 font-semibold">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-[10px]">
                                                {{ $student->initials }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">{{ $student->full_name }}</p>
                                                <p class="text-xs text-slate-400">{{ $student->email }}</p>
                                            </div>
                                            @if($existing)
                                                <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-medium">Existing</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <input type="number" name="grades[{{ $index }}][ca_score]" min="0" max="40" step="0.01" value="{{ old("grades.{$index}.ca_score", $ca) }}" placeholder="0"
                                            class="w-20 text-center px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition ca-input"
                                            oninput="updateRow(this)">
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <input type="number" name="grades[{{ $index }}][exam_score]" min="0" max="60" step="0.01" value="{{ old("grades.{$index}.exam_score", $exam) }}" placeholder="0"
                                            class="w-20 text-center px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition exam-input"
                                            oninput="updateRow(this)">
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="total-display text-sm font-bold text-slate-700">{{ $total ? number_format($total, 2) : '—' }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="grade-display inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold
                                            {{ $grade === 'A' || $grade === 'B' ? 'bg-emerald-100 text-emerald-700' : ($grade === 'C' ? 'bg-blue-100 text-blue-700' : ($grade === 'D' || $grade === 'E' ? 'bg-amber-100 text-amber-700' : ($grade === 'F' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-400'))) }}">
                                            {{ $grade ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <input type="text" name="grades[{{ $index }}][remarks]" value="{{ old("grades.{$index}.remarks", $existing?->remarks) }}" placeholder="Optional remarks..."
                                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                    </td>
                                    <input type="hidden" name="grades[{{ $index }}][student_id]" value="{{ $student->id }}">
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <p class="text-xs text-slate-400">Rows with both scores empty will be skipped. Existing grades will be updated.</p>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Save All Grades
                </button>
            </div>
        </form>
        @elseif(request()->hasAny(['class_id', 'subject_id', 'term_id']))
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-400">No students found</p>
                <p class="text-xs text-slate-400 mt-1">Make sure the selected class has students assigned to it.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-brand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-400">Select class, subject, and term above</p>
                <p class="text-xs text-slate-400 mt-1">The grade entry grid will appear here once you make your selections.</p>
            </div>
        @endif
    </div>

    <script>
        function updateRow(input) {
            const row = input.closest('.grade-row');
            const caInput = row.querySelector('.ca-input');
            const examInput = row.querySelector('.exam-input');
            const totalDisplay = row.querySelector('.total-display');
            const gradeDisplay = row.querySelector('.grade-display');

            const ca = parseFloat(caInput.value) || 0;
            const exam = parseFloat(examInput.value) || 0;
            const total = ca + exam;

            if (caInput.value || examInput.value) {
                totalDisplay.textContent = total.toFixed(2);

                // Calculate grade
                let grade = 'F';
                if (total >= 70) grade = 'A';
                else if (total >= 60) grade = 'B';
                else if (total >= 50) grade = 'C';
                else if (total >= 45) grade = 'D';
                else if (total >= 40) grade = 'E';

                gradeDisplay.textContent = grade;
                gradeDisplay.className = 'inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold ' +
                    (grade === 'A' || grade === 'B' ? 'bg-emerald-100 text-emerald-700' :
                    (grade === 'C' ? 'bg-blue-100 text-blue-700' :
                    (grade === 'D' || grade === 'E' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')));
            } else {
                totalDisplay.textContent = '—';
                gradeDisplay.textContent = '—';
                gradeDisplay.className = 'inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold bg-gray-100 text-gray-400';
            }
        }

        // Initialize existing rows
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.grade-row').forEach(row => {
                const ca = row.querySelector('.ca-input');
                if (ca && ca.value) updateRow(ca);
            });
        });
    </script>
@endsection
