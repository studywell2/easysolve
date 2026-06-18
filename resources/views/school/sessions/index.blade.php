@extends('layouts.school')

@section('title', 'Academic Sessions')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Sessions & Terms</h1>
                <p class="text-sm text-slate-500 mt-1">Manage academic years and terms</p>
            </div>
            <a href="{{ route('school.sessions.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Session
            </a>
        </div>

        <div class="space-y-6">
            @forelse($sessions as $session)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center border border-brand-100/50">
                            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg font-bold text-slate-800">{{ $session->name }}</h2>
                                @if($session->is_current)
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Current
                                </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500 mt-0.5">{{ $session->start_date->format('M d, Y') }} — {{ $session->end_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('school.sessions.edit', $session) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                        </a>
                        <form method="POST" action="{{ route('school.sessions.destroy', $session) }}" onsubmit="return confirm('Delete this session?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                @if($session->terms->count())
                <div class="border-t border-gray-100 px-6 py-4 bg-gray-50/50">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($session->terms as $term)
                        <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center justify-between hover:shadow-sm transition">
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-slate-800">{{ $term->name }}</p>
                                    @if($term->is_current)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                        Current
                                    </span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $term->start_date->format('M d') }} — {{ $term->end_date->format('M d, Y') }}</p>
                            </div>
                            @if(!$term->is_current)
                            <form method="POST" action="{{ route('school.terms.set-current', $term) }}">
                                @csrf
                                <button type="submit" class="text-xs text-brand-600 hover:text-brand-700 font-semibold transition">Set Current</button>
                            </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-400">No academic sessions created yet</p>
                <p class="text-xs text-slate-400 mt-1">Get started by creating your first academic session.</p>
            </div>
            @endforelse
        </div>

        @if($sessions->hasPages())
        <div class="mt-6">{{ $sessions->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection