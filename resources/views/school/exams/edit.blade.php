@extends('layouts.school')

@section('title', 'Edit Exam')

@section('content')
<div class="animate-fade-up max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Exam</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $exam->name }}</p>
        </div>
        <a href="{{ route('school.exams.show', $exam) }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('school.exams.update', $exam) }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Exam Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $exam->name) }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">{{ old('description', $exam->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Class</label>
                <select name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Classes</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ old('class_id', $exam->class_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Term</label>
                <select name="term_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">None</option>
                    @foreach($terms as $t)
                    <option value="{{ $t->id }}" {{ old('term_id', $exam->term_id) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Start Date <span class="text-red-500">*</span></label>
                <input type="date" name="start_date" value="{{ old('start_date', $exam->start_date->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $exam->end_date?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
        </div>

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Status</label>
            <select name="status" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                <option value="draft" {{ old('status', $exam->status) == 'draft' ? 'selected' : '' }}>Draft (not visible to students)</option>
                <option value="published" {{ old('status', $exam->status) == 'published' ? 'selected' : '' }}>Published (visible to students &amp; parents)</option>
            </select>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">Save Changes</button>
            <a href="{{ route('school.exams.show', $exam) }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>
@endsection
