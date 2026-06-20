@extends('layouts.school')

@section('title', 'New Homework Assignment')

@section('content')
<div class="animate-fade-up max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">New Homework Assignment</h1>
            <p class="text-sm text-slate-500 mt-1">Create a new assignment for a class</p>
        </div>
        <a href="{{ route('school.homework.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('school.homework.store') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        @csrf

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="e.g. Chapter 5 Exercises — Algebra">
            @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Description</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="Instructions for students...">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Class <span class="text-red-500">*</span></label>
                <select name="class_id" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">Select class...</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('class_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Subject</label>
                <select name="subject_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">Optional...</option>
                    @foreach($subjects as $s)
                    <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Due Date <span class="text-red-500">*</span></label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                @error('due_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Max Score</label>
                <input type="number" name="max_score" value="{{ old('max_score', 100) }}" min="1" max="999" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                @error('max_score') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Term (optional)</label>
            <select name="term_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                <option value="">Auto (current term)</option>
                @foreach($terms as $t)
                <option value="{{ $t->id }}" {{ old('term_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">Create Assignment</button>
            <a href="{{ route('school.homework.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>
@endsection
