@extends('layouts.school')

@section('title', 'Messages')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Messages</h1>
                <p class="text-sm text-slate-500 mt-1">Your conversations with school staff and parents</p>
            </div>
            <a href="{{ route('school.messages.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                New Message
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            @forelse($conversations as $conv)
            @php
                $other = $conv->otherParticipant(auth()->user());
                $unread = $conv->unreadCountFor(auth()->user());
                $lastMsg = $conv->messages->first();
            @endphp
            <a href="{{ route('school.messages.show', $conv) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50/50 transition border-b border-gray-50 last:border-0 group">
                <div class="relative flex-shrink-0">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        {{ $other?->initials ?? '?' }}
                    </div>
                    @if($unread > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-brand-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">{{ $unread }}</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-sm font-bold text-slate-900 truncate {{ $unread > 0 ? '' : 'text-slate-700' }}">{{ $other?->full_name ?? 'Unknown' }}</p>
                        <span class="text-xs text-slate-400 flex-shrink-0">{{ $conv->last_message_at?->diffForHumans() ?? '' }}</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $conv->subject }}</p>
                    @if($lastMsg)
                    <p class="text-xs text-slate-500 mt-1 truncate {{ $unread > 0 ? 'font-semibold text-slate-700' : '' }}">
                        @if($lastMsg->sender_id === auth()->id())<span class="text-slate-400">You: </span>@endif
                        {{ Illuminate\Support\Str::limit(strip_tags($lastMsg->body), 80) }}
                    </p>
                    @endif
                </div>
                <svg class="w-5 h-5 text-slate-300 group-hover:text-brand-500 transition flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
            @empty
            <div class="py-16 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.294 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v.51z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">No conversations yet</p>
                    <p class="text-xs text-slate-400 mt-1">Start a new conversation to send a message.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($conversations->hasPages())
        <div class="mt-6">{{ $conversations->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
