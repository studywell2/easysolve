@extends('layouts.school')

@section('title', 'New Event')

@section('content')
<div class="animate-fade-up max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">New Event</h1>
            <p class="text-sm text-slate-500 mt-1">Add an event to the school calendar</p>
        </div>
        <a href="{{ route('school.events.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">← Back</a>
    </div>

    <form method="POST" action="{{ route('school.events.store') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        @csrf

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="e.g. First Term Exams Begin">
            @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="Event details...">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Type <span class="text-red-500">*</span></label>
                <select name="type" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    @foreach(\App\Models\SchoolEvent::types() as $value => $label)
                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Audience <span class="text-red-500">*</span></label>
                <select name="audience" required id="event-audience" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" onchange="toggleClassSelect()">
                    <option value="all" {{ old('audience') == 'all' ? 'selected' : '' }}>Everyone</option>
                    <option value="parents" {{ old('audience') == 'parents' ? 'selected' : '' }}>Parents Only</option>
                    <option value="students" {{ old('audience') == 'students' ? 'selected' : '' }}>Students Only</option>
                    <option value="class" {{ old('audience') == 'class' ? 'selected' : '' }}>Specific Class</option>
                </select>
            </div>
        </div>

        <div id="class-select-wrapper" class="hidden">
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Class</label>
            <select name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                <option value="">Select class...</option>
                @foreach($classes as $c)
                <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Start Date <span class="text-red-500">*</span></label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                @error('start_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">End Date (optional)</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                @error('end_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Start Time (optional)</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div>
                <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">End Time (optional)</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
        </div>

        <div>
            <label class="text-[13px] font-semibold text-slate-700 mb-1.5 block">Location (optional)</label>
            <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="e.g. School Hall, Room 101">
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">Create Event</button>
            <a href="{{ route('school.events.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>

<script>
    function toggleClassSelect() {
        const audience = document.getElementById('event-audience').value;
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
