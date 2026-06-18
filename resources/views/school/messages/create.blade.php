@extends('layouts.school')

@section('title', 'New Message')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.messages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Messages
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">New Message</h1>
            <p class="text-sm text-slate-400 mt-0.5">Start a new conversation</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.messages.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="recipient_id" class="block text-sm font-semibold text-slate-700 mb-1.5">To</label>
                        <select id="recipient_id" name="recipient_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select a recipient</option>
                            @foreach($recipients as $r)
                            <option value="{{ $r->id }}" {{ old('recipient_id') == $r->id ? 'selected' : '' }}>
                                {{ $r->full_name }} — {{ ucfirst($r->role) }}
                            </option>
                            @endforeach
                        </select>
                        @error('recipient_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-slate-700 mb-1.5">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="e.g. Regarding my child's attendance" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="body" class="block text-sm font-semibold text-slate-700 mb-1.5">Message</label>
                        <textarea id="body" name="body" rows="6" placeholder="Write your message…" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none">{{ old('body') }}</textarea>
                        @error('body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3 9m0 0l3-3M3 9h12a3 3 0 013 3v6m-3 0l3-3m0 0l-3 3"/></svg>
                        Send Message
                    </button>
                    <a href="{{ route('school.messages.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
