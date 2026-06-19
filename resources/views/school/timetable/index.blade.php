@extends('layouts.school')

@section('title', 'Timetable')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Timetable</h1>
                <p class="text-sm text-slate-500 mt-1">Weekly class schedule</p>
            </div>
            @if(auth()->user()->canManageSchool())
            <a href="{{ route('school.timetable.create') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Entry
            </a>
            @endif
        </div>

        {{-- Class Selector --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('school.timetable.index') }}" class="flex items-center gap-3">
                <label class="text-sm font-semibold text-slate-500 whitespace-nowrap">Viewing:</label>
                <select name="class_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ (string)$selectedClass === (string)$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Weekly Grid --}}
        @php
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            $dayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left px-4 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider w-28">Time</th>
                            @foreach($days as $i => $day)
                                <th class="text-center px-3 py-3 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">{{ $dayLabels[$i] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- Time slots --}}
                        @php
                            // Collect all unique time slots from the timetable
                            $timeSlots = collect();
                            foreach ($timetables as $dayEntries) {
                                foreach ($dayEntries as $entry) {
                                    $key = $entry->start_time->format('H:i') . '-' . $entry->end_time->format('H:i');
                                    $timeSlots[$key] = [
                                        'start' => $entry->start_time->format('H:i'),
                                        'end' => $entry->end_time->format('H:i'),
                                    ];
                                }
                            }
                            $timeSlots = $timeSlots->sortBy('start');
                        @endphp

                        @forelse($timeSlots as $slotKey => $slot)
                            <tr class="hover:bg-gray-50/30 transition">
                                <td class="px-4 py-3 text-xs text-slate-400 font-mono whitespace-nowrap">
                                    {{ \Carbon\Carbon::createFromFormat('H:i', $slot['start'])->format('g:i A') }}
                                    <br>
                                    <span class="text-[10px]">{{ \Carbon\Carbon::createFromFormat('H:i', $slot['end'])->format('g:i A') }}</span>
                                </td>
                                @foreach($days as $day)
                                    @php
                                        $entry = $timetables->get($day)?->first(function ($e) use ($slot) {
                                            return $e->start_time->format('H:i') === $slot['start']
                                                && $e->end_time->format('H:i') === $slot['end'];
                                        });
                                    @endphp
                                    <td class="px-2 py-2">
                                        @if($entry)
                                            <div class="rounded-lg p-2.5 border-l-3 transition hover:shadow-sm
                                                {{ $entry->subject->code === 'MTH' || str_contains(strtolower($entry->subject->name), 'math') ? 'bg-blue-50 border-blue-400' :
                                                  (str_contains(strtolower($entry->subject->name), 'eng') ? 'bg-purple-50 border-purple-400' :
                                                  (str_contains(strtolower($entry->subject->name), 'sci') ? 'bg-emerald-50 border-emerald-400' :
                                                  'bg-amber-50 border-amber-400')) }}">
                                                <p class="text-[11px] font-bold text-slate-800 truncate">{{ $entry->subject->name }}</p>
                                                <p class="text-[10px] text-slate-500 mt-0.5 truncate">{{ $entry->teacher->full_name }}</p>
                                                @if($entry->room)
                                                <p class="text-[9px] text-slate-400 mt-0.5">📍 {{ $entry->room }}</p>
                                                @endif
                                                @if(auth()->user()->canManageSchool())
                                                <div class="flex gap-1 mt-1.5">
                                                    <a href="{{ route('school.timetable.edit', $entry) }}" class="text-[9px] text-brand-600 hover:underline">Edit</a>
                                                    <form method="POST" action="{{ route('school.timetable.destroy', $entry) }}" onsubmit="return confirm('Remove this timetable entry?')" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-[9px] text-red-500 hover:underline ml-1">Delete</button>
                                                    </form>
                                                </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="h-12"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-16 text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0V11.25c0-1.243 1.007-2.25 2.25-2.25h13.5c1.243 0 2.25 1.007 2.25 2.25v7.5"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No timetable entries yet</p>
                                    <p class="text-xs text-slate-400 mt-1">Add timetable entries to build the weekly schedule.</p>
                                    @if(auth()->user()->canManageSchool())
                                    <a href="{{ route('school.timetable.create') }}" class="inline-flex items-center gap-2 mt-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                        Add First Entry
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
