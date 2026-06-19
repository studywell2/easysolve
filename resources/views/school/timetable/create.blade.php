@extends('layouts.school')

@section('title', 'Add Timetable Entry')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.timetable.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Timetable
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Add Timetable Entry</h1>
            <p class="text-sm text-slate-400 mt-0.5">Schedule a lesson for a class</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.timetable.store') }}">
                @csrf
                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                            <select id="class_id" name="class_id" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <option value="">Select Class</option>
                                @foreach($classes as $c)<option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                            </select>
                            @error('class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="subject_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Subject</label>
                            <select id="subject_id" name="subject_id" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $s)<option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach
                            </select>
                            @error('subject_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="teacher_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Teacher</label>
                        <select id="teacher_id" name="teacher_id" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $t)<option value="{{ $t->id }}" {{ old('teacher_id') == $t->id ? 'selected' : '' }}>{{ $t->full_name }}</option>@endforeach
                        </select>
                        @error('teacher_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="day_of_week" class="block text-sm font-semibold text-slate-700 mb-1.5">Day</label>
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                            @php($days = ['monday' => 'Mon', 'tuesday' => 'Tue', 'wednesday' => 'Wed', 'thursday' => 'Thu', 'friday' => 'Fri', 'saturday' => 'Sat', 'sunday' => 'Sun'])
                            @foreach($days as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="day_of_week" value="{{ $value }}" {{ old('day_of_week') === $value ? 'checked' : '' }} class="peer sr-only" required>
                                <div class="text-center py-2.5 rounded-xl border border-gray-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-700 text-sm font-semibold text-slate-600 transition">
                                    {{ $label }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('day_of_week')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-slate-700 mb-1.5">Start Time</label>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('start_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-slate-700 mb-1.5">End Time</label>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('end_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="room" class="block text-sm font-semibold text-slate-700 mb-1.5">Room <span class="text-slate-400 font-normal">(optional)</span></label>
                        <input type="text" id="room" name="room" value="{{ old('room') }}" placeholder="e.g. Room 101, Science Lab..." class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('room')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Add Entry
                    </button>
                    <a href="{{ route('school.timetable.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
