@extends('layouts.school')

@section('title', 'Conversation')

@php $authUser = auth()->user(); @endphp

@section('styles')
<style>
    .chat-scroll::-webkit-scrollbar { width: 4px; }
    .chat-scroll::-webkit-scrollbar-track { background: transparent; }
    .chat-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.08); border-radius: 4px; }
    .chat-scroll::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.15); }
</style>
@endsection

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.messages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Messages
        </a>

        @php $other = $conversation->otherParticipant($authUser); @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col" style="height: calc(100vh - 200px); min-height: 500px;">
            <!-- Header -->
            <div class="flex items-center gap-3 p-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="relative flex-shrink-0">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                        {{ $other?->initials ?? '?' }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900">{{ $other?->full_name ?? 'Unknown' }}</p>
                    <p class="text-xs text-slate-400">{{ ucfirst($other?->role ?? '') }}</p>
                </div>
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-xs font-semibold text-slate-700 truncate max-w-[200px]">{{ $conversation->subject }}</span>
                    <span class="text-[10px] text-slate-400">Started {{ $conversation->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto chat-scroll p-4 sm:p-6 space-y-4 bg-gray-50/50" id="chat-container">
                @foreach($conversation->messages as $msg)
                @php $isOwn = $msg->sender_id === $authUser->id; @endphp
                <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                    <div class="flex items-end gap-2 max-w-[75%] sm:max-w-[60%]">
                        @if(!$isOwn)
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center text-white font-bold text-[10px] flex-shrink-0 shadow-sm">
                            {{ $msg->sender?->initials ?? '?' }}
                        </div>
                        @endif
                        <div class="{{ $isOwn ? 'bg-brand-600 text-white' : 'bg-white text-slate-700 border border-gray-100' }} rounded-2xl {{ $isOwn ? 'rounded-br-md' : 'rounded-bl-md' }} px-4 py-2.5 shadow-sm">
                            <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->body }}</p>
                            <p class="text-[10px] {{ $isOwn ? 'text-brand-200' : 'text-slate-400' }} mt-1 text-right">{{ $msg->created_at->format('M j, g:i A') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Reply Form -->
            <div class="border-t border-gray-100 p-3 sm:p-4 bg-white">
                <form method="POST" action="{{ route('school.messages.reply', $conversation) }}" class="flex items-end gap-2">
                    @csrf
                    <div class="flex-1 relative">
                        <textarea name="body" rows="1" placeholder="Type your reply…" class="w-full pl-4 pr-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none" onkeydown="handleKeyDown(event)" id="reply-textarea"></textarea>
                        @error('body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold p-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition flex-shrink-0" title="Send">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3 9m0 0l3-3M3 9h12a3 3 0 013 3v6m-3 0l3-3m0 0l-3 3"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to bottom on load
        const chatContainer = document.getElementById('chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight;

        // Auto-grow textarea
        const textarea = document.getElementById('reply-textarea');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Ctrl+Enter to send
        function handleKeyDown(e) {
            if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                e.target.closest('form').submit();
            }
        }

        textarea.focus();
    </script>
@endsection
