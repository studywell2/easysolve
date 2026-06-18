@extends('layouts.school')

@section('title', $announcement->title)

@section('content')
    <div class="animate-fade-up max-w-3xl">
        <a href="{{ route('school.announcements.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Announcements
        </a>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-100 bg-gradient-to-br from-gray-50 to-white">
                <div class="flex items-center gap-2 flex-wrap mb-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full
                        {{ $announcement->audience === 'all' ? 'bg-brand-50 text-brand-600' : '' }}
                        {{ $announcement->audience === 'parents' ? 'bg-purple-50 text-purple-600' : '' }}
                        {{ $announcement->audience === 'students' ? 'bg-emerald-50 text-emerald-600' : '' }}
                        {{ $announcement->audience === 'class' ? 'bg-amber-50 text-amber-600' : '' }}">
                        {{ $announcement->audience === 'all' ? 'Everyone' : ($announcement->audience === 'class' ? ($announcement->schoolClass?->name ?? 'Class') : ucfirst($announcement->audience)) }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $announcement->created_at->format('M j, Y \a\t g:i A') }}</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">{{ $announcement->title }}</h1>
                <div class="flex items-center gap-3 mt-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                        {{ $announcement->creator?->initials ?? '?' }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">{{ $announcement->creator?->full_name ?? 'Unknown' }}</p>
                        <p class="text-xs text-slate-400">{{ ucfirst($announcement->creator?->role ?? '') }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 sm:p-8">
                <div class="prose prose-sm max-w-none text-slate-600 whitespace-pre-wrap leading-relaxed">{{ $announcement->body }}</div>
            </div>
        </div>

        @if(auth()->user()->canManageSchool() && (auth()->user()->id === $announcement->created_by || auth()->user()->isOwner() || auth()->user()->isAdmin()))
        <div class="flex items-center gap-3 mt-4">
            <a href="{{ route('school.announcements.edit', $announcement) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 px-4 py-2 rounded-xl bg-brand-50 hover:bg-brand-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('school.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700 px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    Delete
                </button>
            </form>
        </div>
        @endif
    </div>
@endsection
