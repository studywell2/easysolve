@extends('layouts.school')

@section('title', 'New Announcement')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.announcements.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Announcements
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">New Announcement</h1>
            <p class="text-sm text-slate-400 mt-0.5">Publish an announcement to parents and students</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.announcements.store') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Parent-Teacher Conference" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="audience" class="block text-sm font-semibold text-slate-700 mb-1.5">Audience</label>
                        <select id="audience" name="audience" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" onchange="toggleClassSelect()">
                            <option value="all" {{ old('audience', 'all') === 'all' ? 'selected' : '' }}>Everyone (Parents & Students)</option>
                            <option value="parents" {{ old('audience') === 'parents' ? 'selected' : '' }}>Parents Only</option>
                            <option value="students" {{ old('audience') === 'students' ? 'selected' : '' }}>Students Only</option>
                            <option value="class" {{ old('audience') === 'class' ? 'selected' : '' }}>Specific Class</option>
                        </select>
                    </div>
                    <div id="class-select-wrapper" class="hidden">
                        <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                        <select id="class_id" name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select a class</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="body" class="block text-sm font-semibold text-slate-700 mb-1.5">Message</label>
                        <textarea id="body" name="body" rows="6" placeholder="Write your announcement here…" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none">{{ old('body') }}</textarea>
                        @error('body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3 9m0 0l3-3M3 9h12a3 3 0 013 3v6m-3 0l3-3m0 0l-3 3"/></svg>
                        Publish Announcement
                    </button>
                    <a href="{{ route('school.announcements.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleClassSelect() {
            const audience = document.getElementById('audience').value;
            const wrapper = document.getElementById('class-select-wrapper');
            if (audience === 'class') {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
        }
        toggleClassSelect();
    </script>
@endsection
