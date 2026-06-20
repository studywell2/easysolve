@extends('layouts.school')

@section('title', $exam->name)

@section('content')
<div class="animate-fade-up">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('school.exams.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Exams
        </a>
        @if(auth()->user()->canManageSchool())
        <div class="flex items-center gap-2">
            <a href="{{ route('school.exams.edit', $exam) }}" class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-slate-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                Edit
            </a>
            @if(!$exam->isPublished())
            <form method="POST" action="{{ route('school.exams.publish', $exam) }}" onsubmit="return confirm('Publish this exam timetable? Students and parents will be able to see it.')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-lg shadow-emerald-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33"/></svg>
                    Publish
                </button>
            </form>
            @endif
            <form method="POST" action="{{ route('school.exams.destroy', $exam) }}" onsubmit="return confirm('Delete this exam and all its schedule entries?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-sm font-semibold px-4 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    Delete
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Exam Details --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-center gap-2 mb-3">
            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-md {{ $exam->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                {{ ucfirst($exam->status) }}
            </span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $exam->name }}</h1>
        @if($exam->description)
        <p class="text-sm text-slate-600 leading-relaxed mb-4">{{ $exam->description }}</p>
        @endif
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-gray-50">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Class</p>
                <p class="text-sm font-semibold text-slate-700">{{ $exam->schoolClass?->name ?? 'All Classes' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Term</p>
                <p class="text-sm font-semibold text-slate-700">{{ $exam->term?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Start Date</p>
                <p class="text-sm font-semibold text-slate-700">{{ $exam->start_date->format('M j, Y') }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">End Date</p>
                <p class="text-sm font-semibold text-slate-700">{{ $exam->end_date?->format('M j, Y') ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Schedule Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">Exam Schedule</h2>
            <span class="text-xs font-medium text-slate-400">{{ $exam->schedules->count() }} subject{{ $exam->schedules->count() === 1 ? '' : 's' }} scheduled</span>
        </div>

        @if($exam->schedules->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-5 py-3">Subject</th>
                        <th class="text-left px-5 py-3">Date</th>
                        <th class="text-left px-5 py-3">Time</th>
                        <th class="text-left px-5 py-3">Room</th>
                        <th class="text-left px-5 py-3">Max Marks</th>
                        @if(auth()->user()->canManageSchool())
                        <th class="text-right px-5 py-3">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($exam->schedules->sortBy('date') as $schedule)
                    <tr class="hover:bg-brand-50/30 transition">
                        <td class="px-5 py-3">
                            <p class="text-sm font-semibold text-slate-700">{{ $schedule->subject->name }}</p>
                            @if($schedule->notes)
                            <p class="text-xs text-slate-400 mt-0.5">{{ $schedule->notes }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $schedule->date->format('M j, Y (D)') }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $schedule->formatted_time }}</td>
                        <td class="px-5 py-3 text-sm text-slate-600">{{ $schedule->room ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-700">{{ $schedule->total_marks }}</td>
                        @if(auth()->user()->canManageSchool())
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('school.exams.schedules.destroy', [$exam, $schedule]) }}" onsubmit="return confirm('Remove this subject from the exam schedule?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Remove</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <p class="text-sm font-semibold text-slate-400">No subjects scheduled yet</p>
            @if(auth()->user()->canManageSchool())
            <p class="text-xs text-slate-400 mt-1">Add subjects to build the exam timetable below.</p>
            @endif
        </div>
        @endif
    </div>

    {{-- Add Subject to Schedule (managers only) --}}
    @if(auth()->user()->canManageSchool() && !$exam->isPublished())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Add Subject to Schedule</h2>
        <form method="POST" action="{{ route('school.exams.schedules.store', $exam) }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Subject <span class="text-red-500">*</span></label>
                <select name="subject_id" required class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">Select subject...</option>
                    @foreach($subjects as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Date <span class="text-red-500">*</span></label>
                <input type="date" name="date" required class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Start Time <span class="text-red-500">*</span></label>
                <input type="time" name="start_time" required class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">End Time <span class="text-red-500">*</span></label>
                <input type="time" name="end_time" required class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Room</label>
                <input type="text" name="room" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="e.g. Hall A">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Max Marks</label>
                <input type="number" name="total_marks" value="100" min="1" max="999" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <div class="sm:col-span-2 lg:col-span-3">
                <label class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Notes (optional)</label>
                <input type="text" name="notes" class="w-full px-3 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" placeholder="e.g. Bring calculator">
            </div>
            <div class="sm:col-span-2 lg:col-span-3">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">Add to Schedule</button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
