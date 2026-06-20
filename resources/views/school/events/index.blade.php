@extends('layouts.school')

@section('title', 'Events & Calendar')

@section('content')
<div class="animate-fade-up">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Events &amp; Calendar</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $upcomingCount }} upcoming event{{ $upcomingCount === 1 ? '' : 's' }}</p>
        </div>
        @if(auth()->user()->canManageSchool())
        <a href="{{ route('school.events.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            New Event
        </a>
        @endif
    </div>

    {{-- View Toggle + Filters --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('school.events.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex bg-gray-100 rounded-xl p-1">
                <button type="submit" name="view" value="upcoming" class="px-4 py-1.5 rounded-lg text-sm font-semibold transition {{ (request('view', 'upcoming') === 'upcoming') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500' }}">Upcoming</button>
                <button type="submit" name="view" value="all" class="px-4 py-1.5 rounded-lg text-sm font-semibold transition {{ request('view') === 'all' ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500' }}">All Events</button>
            </div>
            <select name="type" onchange="this.form.submit()" class="px-4 py-2 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 transition">
                <option value="">All Types</option>
                @foreach(\App\Models\SchoolEvent::types() as $value => $label)
                <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Events Timeline --}}
    <div class="space-y-3">
        @forelse($events as $event)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start gap-4 hover:shadow-md transition-all duration-200">
            {{-- Date Block --}}
            <div class="flex-shrink-0 text-center">
                <div class="w-14 h-16 rounded-xl flex flex-col items-center justify-center {{ $event->type_color }} border">
                    <span class="text-[10px] font-bold uppercase">{{ $event->start_date->format('M') }}</span>
                    <span class="text-xl font-extrabold leading-none">{{ $event->start_date->format('j') }}</span>
                    @if($event->end_date && $event->end_date != $event->start_date)
                    <span class="text-[9px] font-semibold text-slate-400">– {{ $event->end_date->format('j') }}</span>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-md border {{ $event->type_color }}">
                        {{ $event->type_label }}
                    </span>
                    <span class="text-[10px] font-medium text-slate-400 uppercase">{{ $event->audience === 'class' ? $event->schoolClass?->name : ucfirst($event->audience) }}</span>
                </div>
                <h3 class="text-sm font-bold text-slate-800 mb-1">{{ $event->title }}</h3>
                @if($event->description)
                <p class="text-xs text-slate-500 line-clamp-2">{{ $event->description }}</p>
                @endif
                <div class="flex items-center gap-3 mt-2 flex-wrap">
                    @if($event->formatted_time)
                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $event->formatted_time }}
                    </span>
                    @endif
                    @if($event->location)
                    <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        {{ $event->location }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            @if(auth()->user()->canManageSchool())
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('school.events.edit', $event) }}" class="text-xs font-semibold text-slate-500 hover:text-brand-600 transition">Edit</a>
                <form method="POST" action="{{ route('school.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-red-500 transition">Delete</button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-400">No events found</p>
            @if(auth()->user()->canManageSchool())
            <a href="{{ route('school.events.create') }}" class="inline-flex items-center gap-2 mt-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Create First Event
            </a>
            @endif
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection
