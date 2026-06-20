@extends('layouts.school')

@section('title', 'Homework')

@section('content')
<div class="animate-fade-up">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Homework &amp; Assignments</h1>
            <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->canManageSchool() ? 'Manage homework assignments for your classes' : 'Your homework assignments and due dates' }}</p>
        </div>
        @if(auth()->user()->canManageSchool())
        <a href="{{ route('school.homework.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            New Assignment
        </a>
        @endif
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('school.homework.index') }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[160px]">
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Class</label>
                <select name="class_id" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Classes</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[160px]">
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Subject</label>
                <select name="subject_id" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $s)
                    <option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(auth()->user()->canManageSchool())
            <div class="flex-1 min-w-[120px]">
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Status</label>
                <select name="status" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            @endif
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Filter</button>
            <a href="{{ route('school.homework.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-3 py-2.5">Reset</a>
        </form>
    </div>

    {{-- Homework Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($homework as $hw)
        <a href="{{ route('school.homework.show', $hw) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-brand-200 transition-all duration-200 group">
            <div class="flex items-start justify-between mb-3">
                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md {{ $hw->status === 'open' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                    {{ ucfirst($hw->status) }}
                </span>
                @if($hw->isOverdue() && $hw->status === 'open')
                <span class="text-[10px] font-bold text-red-500">OVERDUE</span>
                @endif
            </div>
            <h3 class="text-sm font-bold text-slate-800 group-hover:text-brand-600 transition line-clamp-2 mb-2">{{ $hw->title }}</h3>
            @if($hw->description)
            <p class="text-xs text-slate-400 line-clamp-2 mb-3">{{ $hw->description }}</p>
            @endif
            <div class="flex items-center gap-2 flex-wrap text-[11px] text-slate-500">
                @if($hw->schoolClass)
                <span class="inline-flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded-md">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75"/></svg>
                    {{ $hw->schoolClass->name }}
                </span>
                @endif
                @if($hw->subject)
                <span class="inline-flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded-md">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    {{ $hw->subject->name }}
                </span>
                @endif
                <span class="inline-flex items-center gap-1 {{ $hw->isOverdue() ? 'text-red-500' : 'text-slate-500' }} px-2 py-0.5 rounded-md {{ $hw->isOverdue() ? 'bg-red-50' : 'bg-gray-50' }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0V11.25c0-1.243 1.007-2.25 2.25-2.25h13.5c1.243 0 2.25 1.007 2.25 2.25v7.5"/></svg>
                    Due {{ $hw->due_date->format('M j, Y') }}
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-400">No homework assignments yet</p>
            @if(auth()->user()->canManageSchool())
            <a href="{{ route('school.homework.create') }}" class="inline-flex items-center gap-2 mt-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Create First Assignment
            </a>
            @endif
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $homework->links() }}
    </div>
</div>
@endsection
