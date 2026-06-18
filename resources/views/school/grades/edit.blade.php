@extends('layouts.school')

@section('title', 'Edit Grade')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.grades.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Grades
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Edit Grade</h1>
            <p class="text-sm text-slate-400 mt-0.5">Update assessment scores</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.grades.update', $grade) }}">
                @csrf @method('PUT')

                <div class="bg-gray-50/80 rounded-xl p-4 mb-5">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div><span class="text-slate-500">Student:</span> <span class="font-semibold text-slate-800">{{ $grade->student?->full_name }}</span></div>
                        <div><span class="text-slate-500">Subject:</span> <span class="font-semibold text-slate-800">{{ $grade->subject?->name }}</span></div>
                        <div><span class="text-slate-500">Term:</span> <span class="font-semibold text-slate-800">{{ $grade->term?->name }}</span></div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="ca_score" class="block text-sm font-semibold text-slate-700 mb-1.5">CA Score (max 40)</label>
                            <input type="number" id="ca_score" name="ca_score" min="0" max="40" step="0.01" value="{{ old('ca_score', $grade->ca_score) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('ca_score')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="exam_score" class="block text-sm font-semibold text-slate-700 mb-1.5">Exam Score (max 60)</label>
                            <input type="number" id="exam_score" name="exam_score" min="0" max="60" step="0.01" value="{{ old('exam_score', $grade->exam_score) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('exam_score')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="remarks" class="block text-sm font-semibold text-slate-700 mb-1.5">Remarks</label>
                        <textarea id="remarks" name="remarks" rows="2" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">{{ old('remarks', $grade->remarks) }}</textarea>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Update Grade
                    </button>
                    <a href="{{ route('school.grades.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection