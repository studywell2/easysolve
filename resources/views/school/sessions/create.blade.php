@extends('layouts.school')

@section('title', 'Add Session')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.sessions.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Sessions
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Add Academic Session</h1>
            <p class="text-sm text-slate-400 mt-0.5">Create a new academic year with terms</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-3xl">
            <form method="POST" action="{{ route('school.sessions.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Session Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. 2025/2026" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-semibold text-slate-700 mb-1.5">Start Date</label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-semibold text-slate-700 mb-1.5">End Date</label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('end_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_current" name="is_current" value="1" {{ old('is_current') ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                        <label for="is_current" class="text-sm text-slate-700">Set as current session</label>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-sm font-semibold text-slate-700">Terms <span class="text-slate-400 font-normal">(optional — fill dates to add terms)</span></label>
                            <button type="button" onclick="addTerm()" class="text-sm text-brand-600 hover:text-brand-700 font-semibold transition">+ Add Term</button>
                        </div>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                @if(str_contains($error, 'terms'))
                                    <p class="text-red-500 text-xs mb-2">{{ $error }}</p>
                                @endif
                            @endforeach
                        @endif
                        <div id="terms-container" class="space-y-4">
                            <div class="term-row bg-gray-50/80 rounded-xl p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="text-xs text-slate-500 mb-1 block">Name</label>
                                        <input type="text" name="terms[0][name]" value="{{ old('terms.0.name', 'First Term') }}" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                    </div>
                                    <div>
                                        <label class="text-xs text-slate-500 mb-1 block">Start Date</label>
                                        <input type="date" name="terms[0][start_date]" value="{{ old('terms.0.start_date') }}" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                    </div>
                                    <div>
                                        <label class="text-xs text-slate-500 mb-1 block">End Date</label>
                                        <input type="date" name="terms[0][end_date]" value="{{ old('terms.0.end_date') }}" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Create Session
                    </button>
                    <a href="{{ route('school.sessions.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let termIndex = 1;
        const termNames = ['First Term', 'Second Term', 'Third Term'];
        function addTerm() {
            const container = document.getElementById('terms-container');
            const row = document.createElement('div');
            row.className = 'term-row bg-gray-50/80 rounded-xl p-4';
            row.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Name</label>
                        <input type="text" name="terms[${termIndex}][name]" value="${termNames[termIndex] || 'Term ' + (termIndex + 1)}" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">Start Date</label>
                        <input type="date" name="terms[${termIndex}][start_date]" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block">End Date</label>
                        <input type="date" name="terms[${termIndex}][end_date]" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                    </div>
                </div>
            `;
            container.appendChild(row);
            termIndex++;
        }
    </script>
    @endpush
@endsection