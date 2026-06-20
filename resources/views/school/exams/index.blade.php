@extends('layouts.school')

@section('title', 'Exams')

@section('content')
<div class="animate-fade-up">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Exam Management</h1>
            <p class="text-sm text-slate-500 mt-1">Exam schedules &amp; timetables</p>
        </div>
        @if(auth()->user()->canManageSchool())
        <a href="{{ route('school.exams.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            New Exam
        </a>
        @endif
    </div>

    @if(auth()->user()->canManageSchool())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('school.exams.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[160px]">
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Class</label>
                <select name="class_id" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 transition">
                    <option value="">All Classes</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[120px]">
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Status</label>
                <select name="status" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 transition">
                    <option value="">All</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Filter</button>
            <a href="{{ route('school.exams.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-3 py-2.5">Reset</a>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($exams as $exam)
        <a href="{{ route('school.exams.show', $exam) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-brand-200 transition-all duration-200 group">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                    @if(auth()->user()->canManageSchool())
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md {{ $exam->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                        {{ ucfirst($exam->status) }}
                    </span>
                    @endif
                </div>
                <span class="text-[10px] font-bold text-slate-400">{{ $exam->schedules->count() }} subject{{ $exam->schedules->count() === 1 ? '' : 's' }}</span>
            </div>
            <h3 class="text-sm font-bold text-slate-800 group-hover:text-brand-600 transition mb-2">{{ $exam->name }}</h3>
            <div class="flex items-center gap-2 flex-wrap text-[11px] text-slate-500">
                @if($exam->schoolClass)
                <span class="inline-flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded-md">{{ $exam->schoolClass->name }}</span>
                @endif
                @if($exam->term)
                <span class="inline-flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded-md">{{ $exam->term->name }}</span>
                @endif
                <span class="inline-flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded-md">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    {{ $exam->formatted_date }}
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-400">No exams scheduled yet</p>
            @if(auth()->user()->canManageSchool())
            <a href="{{ route('school.exams.create') }}" class="inline-flex items-center gap-2 mt-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Create First Exam
            </a>
            @endif
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $exams->links() }}
    </div>
</div>
@endsection
