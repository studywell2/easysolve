@extends('layouts.school')

@section('title', $homework->title)

@section('content')
<div class="animate-fade-up">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('school.homework.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Homework
        </a>
        @if(auth()->user()->canManageSchool())
        <div class="flex items-center gap-2">
            <a href="{{ route('school.homework.edit', $homework) }}" class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-slate-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('school.homework.destroy', $homework) }}" onsubmit="return confirm('Delete this assignment? All submissions will be lost.')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-sm font-semibold px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    Delete
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Assignment Details --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md {{ $homework->status === 'open' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                        {{ ucfirst($homework->status) }}
                    </span>
                    @if($homework->isOverdue() && $homework->status === 'open')
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md bg-red-50 text-red-600">Overdue</span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $homework->title }}</h1>
                @if($homework->description)
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $homework->description }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-gray-50">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Class</p>
                <p class="text-sm font-semibold text-slate-700">{{ $homework->schoolClass?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Subject</p>
                <p class="text-sm font-semibold text-slate-700">{{ $homework->subject?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Due Date</p>
                <p class="text-sm font-semibold {{ $homework->isOverdue() ? 'text-red-600' : 'text-slate-700' }}">{{ $homework->due_date->format('M j, Y') }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Max Score</p>
                <p class="text-sm font-semibold text-slate-700">{{ $homework->max_score }}</p>
            </div>
        </div>
    </div>

    @if(auth()->user()->isStudent() && $homework->status === 'open')
    {{-- Student Submission Form --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Submit Your Work</h2>
        @if($studentSubmission && $studentSubmission->isSubmitted())
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-semibold text-emerald-700">
                        Submitted on {{ $studentSubmission->submitted_at->format('M j, Y \a\t g:i A') }}
                        @if($studentSubmission->status === 'late')
                        <span class="text-red-500">(Late)</span>
                        @endif
                    </p>
                </div>
                @if($studentSubmission->isGraded())
                <div class="mt-4 pt-4 border-t border-emerald-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-700">Score: {{ $studentSubmission->score }} / {{ $homework->max_score }}</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-blue-600">GRADED</span>
                    </div>
                    @if($studentSubmission->feedback)
                    <p class="text-sm text-slate-600 mt-2 p-3 bg-white rounded-lg border border-gray-100">{{ $studentSubmission->feedback }}</p>
                    @endif
                </div>
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('school.homework.submit', $homework) }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Your Answer / Notes</label>
                    <textarea name="content" rows="4" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="Type your answer here...">{{ old('content', $studentSubmission?->content) }}</textarea>
                </div>
                <div>
                    <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Attach File (optional, max 10MB)</label>
                    <input type="file" name="file" class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                </div>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                    {{ $studentSubmission && $studentSubmission->isSubmitted() ? 'Update Submission' : 'Submit Homework' }}
                </button>
            </div>
        </form>
    </div>
    @endif

    @if(auth()->user()->canManageSchool() && $submissions->isNotEmpty())
    {{-- Teacher: View Submissions --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50">
            <h2 class="text-lg font-bold text-slate-800">Student Submissions ({{ $homework->submissions()->count() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-5 py-3">Student</th>
                        <th class="text-left px-5 py-3">Status</th>
                        <th class="text-left px-5 py-3">Submitted</th>
                        <th class="text-left px-5 py-3">Score</th>
                        <th class="text-right px-5 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($submissions as $sub)
                    <tr class="hover:bg-brand-50/30 transition">
                        <td class="px-5 py-3">
                            <p class="text-sm font-semibold text-slate-700">{{ $sub->student->full_name }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md
                                {{ $sub->status === 'graded' ? 'bg-blue-50 text-blue-600' :
                                  ($sub->status === 'submitted' ? 'bg-emerald-50 text-emerald-600' :
                                  ($sub->status === 'late' ? 'bg-amber-50 text-amber-600' : 'bg-gray-100 text-slate-500')) }}">
                                {{ ucfirst($sub->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-sm text-slate-500">{{ $sub->submitted_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-700">
                            @if($sub->isGraded())
                                {{ $sub->score }} / {{ $homework->max_score }}
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            @if(!$sub->isGraded() && $sub->isSubmitted())
                            <button onclick="openGradeModal({{ $sub->id }}, '{{ addslashes($sub->student->full_name) }}', {{ $homework->max_score }})" class="text-xs font-semibold text-brand-600 hover:underline">Grade</button>
                            @elseif($sub->isGraded())
                            <button onclick="openGradeModal({{ $sub->id }}, '{{ addslashes($sub->student->full_name) }}', {{ $homework->max_score }}, {{ $sub->score }}, '{{ addslashes($sub->feedback ?? '') }}')" class="text-xs font-semibold text-slate-500 hover:underline">Edit Grade</button>
                            @else
                            <span class="text-xs text-slate-300">Not submitted</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-50">
            {{ $submissions->links() }}
        </div>
    </div>
    @endif

    @if(auth()->user()->isParent() && $studentSubmission && $studentSubmission->isNotEmpty())
    {{-- Parent: View children's submissions --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50">
            <h2 class="text-lg font-bold text-slate-800">Submissions</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($studentSubmission as $sub)
            <div class="p-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-semibold text-slate-700">{{ $sub->student->full_name }}</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md
                        {{ $sub->status === 'graded' ? 'bg-blue-50 text-blue-600' :
                          ($sub->status === 'submitted' ? 'bg-emerald-50 text-emerald-600' :
                          ($sub->status === 'late' ? 'bg-amber-50 text-amber-600' : 'bg-gray-100 text-slate-500')) }}">
                        {{ ucfirst($sub->status) }}
                    </span>
                </div>
                @if($sub->isGraded())
                <p class="text-sm text-slate-600">Score: <span class="font-bold">{{ $sub->score }} / {{ $homework->max_score }}</span></p>
                @if($sub->feedback)
                <p class="text-xs text-slate-500 mt-1 p-2 bg-gray-50 rounded-lg">{{ $sub->feedback }}</p>
                @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- Grade Modal --}}
@if(auth()->user()->canManageSchool())
<div id="grade-modal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800">Grade Submission</h3>
            <button onclick="closeGradeModal()" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <p class="text-sm text-slate-500 mb-4">Grade for: <span id="grade-student-name" class="font-semibold text-slate-700"></span></p>
        <form id="grade-form" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Score <span class="text-slate-400">(max: <span id="grade-max-score">100</span>)</span></label>
                <input type="number" id="grade-score" name="score" min="0" step="0.5" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div class="mb-4">
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Feedback (optional)</label>
                <textarea id="grade-feedback" name="feedback" rows="3" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="Comments for the student..."></textarea>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl transition text-sm">Save Grade</button>
                <button type="button" onclick="closeGradeModal()" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-2.5">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openGradeModal(submissionId, studentName, maxScore, existingScore, existingFeedback) {
        document.getElementById('grade-form').action = '{{ route('school.homework.grade', ['submission' => '__ID__']) }}'.replace('__ID__', submissionId);
        document.getElementById('grade-student-name').textContent = studentName;
        document.getElementById('grade-max-score').textContent = maxScore;
        document.getElementById('grade-score').max = maxScore;
        document.getElementById('grade-score').value = existingScore || '';
        document.getElementById('grade-feedback').value = existingFeedback || '';
        const modal = document.getElementById('grade-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeGradeModal() {
        const modal = document.getElementById('grade-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endif
@endsection
