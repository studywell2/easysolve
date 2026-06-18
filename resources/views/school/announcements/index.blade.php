@extends('layouts.school')

@section('title', 'Announcements')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Announcements</h1>
                <p class="text-sm text-slate-500 mt-1">@if(auth()->user()->canManageSchool()) School-wide announcements and updates @else Stay up to date with school announcements @endif</p>
            </div>
            @if(auth()->user()->canManageSchool())
            <a href="{{ route('school.announcements.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Announcement
            </a>
            @endif
        </div>

        @if(auth()->user()->canManageSchool())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="audience" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Audiences</option>
                    <option value="all" {{ request('audience') === 'all' ? 'selected' : '' }}>Everyone</option>
                    <option value="parents" {{ request('audience') === 'parents' ? 'selected' : '' }}>Parents</option>
                    <option value="students" {{ request('audience') === 'students' ? 'selected' : '' }}>Students</option>
                    <option value="class" {{ request('audience') === 'class' ? 'selected' : '' }}>Class-specific</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5H14.25M14.25 4.5V9m0-4.5H21M14.25 4.5L21 9M3 19.5h6.75M9.75 19.5V15m0 4.5H3M9.75 19.5L3 15"/></svg>
                    Filter
                </button>
            </form>
        </div>
        @endif

        @forelse($announcements as $a)
        <a href="{{ route('school.announcements.show', $a) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-200 transition-all duration-200 p-5 mb-4 group">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center
                    {{ $a->audience === 'all' ? 'bg-brand-50 text-brand-600' : '' }}
                    {{ $a->audience === 'parents' ? 'bg-purple-50 text-purple-600' : '' }}
                    {{ $a->audience === 'students' ? 'bg-emerald-50 text-emerald-600' : '' }}
                    {{ $a->audience === 'class' ? 'bg-amber-50 text-amber-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-1">
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition">{{ $a->title }}</h3>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full
                            {{ $a->audience === 'all' ? 'bg-brand-50 text-brand-600' : '' }}
                            {{ $a->audience === 'parents' ? 'bg-purple-50 text-purple-600' : '' }}
                            {{ $a->audience === 'students' ? 'bg-emerald-50 text-emerald-600' : '' }}
                            {{ $a->audience === 'class' ? 'bg-amber-50 text-amber-600' : '' }}">
                            {{ $a->audience === 'all' ? 'Everyone' : ($a->audience === 'class' ? ($a->schoolClass?->name ?? 'Class') : ucfirst($a->audience)) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 line-clamp-2">{{ Illuminate\Support\Str::limit(strip_tags($a->body), 150) }}</p>
                    <div class="flex items-center gap-3 mt-2.5 text-xs text-slate-400">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.648 0-5.195-.429-7.499-1.118z"/></svg>
                            {{ $a->creator?->full_name }}
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            {{ $a->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-brand-500 transition flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm py-16 text-center">
            <div class="flex flex-col items-center justify-center">
                <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-400">No announcements yet</p>
                <p class="text-xs text-slate-400 mt-1">@if(auth()->user()->canManageSchool()) Publish your first announcement to keep parents and students informed. @else Check back later for school updates. @endif</p>
            </div>
        </div>
        @endforelse

        @if($announcements->hasPages())
        <div class="mt-6">{{ $announcements->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
