@extends('layouts.school')

@section('title', 'Issue Book')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.library.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Library
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Issue Book</h1>
            <p class="text-sm text-slate-400 mt-0.5">Lend a book to a student</p>
        </div>

        {{-- Book Info Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6 max-w-2xl">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-slate-900">{{ $book->title }}</h3>
                    <p class="text-sm text-slate-500">{{ $book->author ?? 'Unknown author' }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-slate-400">Copies: <span class="font-semibold text-slate-600">{{ $book->quantity }}</span></span>
                        <span class="text-xs text-slate-400">Available: <span class="font-semibold text-emerald-600">{{ $book->available_copies }}</span></span>
                    </div>
                </div>
            </div>
        </div>

        @if($book->available_copies <= 0)
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-center gap-3 max-w-2xl mb-6">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium">No copies available for issue.</p>
                <p class="text-xs text-red-500 mt-0.5">All copies are currently issued to students.</p>
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.library.issue', $book) }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="user_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Student <span class="text-red-400">*</span></label>
                        <select id="user_id" name="user_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select a student...</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->full_name }} — {{ $student->schoolClass?->name ?? 'No class' }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="issue_date" class="block text-sm font-semibold text-slate-700 mb-1.5">Issue Date <span class="text-red-400">*</span></label>
                            <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date', now()->toDateString()) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('issue_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-semibold text-slate-700 mb-1.5">Due Date <span class="text-red-400">*</span></label>
                            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', now()->addDays(14)->toDateString()) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('due_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Notes</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Optional notes about this issue..." class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">{{ old('notes') }}</textarea>
                        @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.75h-4.5a2.25 2.25 0 00-2.25 2.25v4.5m0 0L8.25 18.75M10.5 9.75l8.25 8.25M3 6.75h4.5a2.25 2.25 0 012.25 2.25v4.5"/></svg>
                        Issue Book
                    </button>
                    <a href="{{ route('school.library.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
        @endif
    </div>
@endsection
