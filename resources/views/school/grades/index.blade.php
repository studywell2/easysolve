@extends('layouts.school')

@section('title', 'Grades')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Grades</h1>
                <p class="text-sm text-slate-500 mt-1">Manage student assessment scores and results</p>
            </div>
            @if(auth()->user()->canManageSchool())
            <div class="flex items-center gap-2">
                <a href="{{ route('school.grades.bulk') }}" class="bg-white hover:bg-gray-50 text-slate-700 border border-gray-200 font-semibold px-4 py-2.5 rounded-xl shadow-sm transition inline-flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/></svg>
                    Bulk Entry
                </a>
                <a href="{{ route('school.grades.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Add Grade
                </a>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="class_id" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Classes</option>
                    @foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                </select>
                <select name="subject_id" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $s)<option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach
                </select>
                <select name="term_id" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Terms</option>
                    @foreach($terms as $t)<option value="{{ $t->id }}" {{ request('term_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>@endforeach
                </select>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5H14.25M14.25 4.5V9m0-4.5H21M14.25 4.5L21 9M3 19.5h6.75M9.75 19.5V15m0 4.5H3M9.75 19.5L3 15"/></svg>
                    Filter
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Student</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Subject</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">CA (40)</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Exam (60)</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">HW Avg</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Total</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Grade</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($grades as $g)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $g->student?->full_name }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $g->subject?->name }}</td>
                            <td class="py-3 px-4 text-center text-slate-600">{{ $g->ca_score }}</td>
                            <td class="py-3 px-4 text-center text-slate-600">{{ $g->exam_score }}</td>
                            @php $hwKey = $g->student_id . '-' . $g->subject_id; $hwAvg = $homeworkAverages[$hwKey] ?? null; @endphp
                            <td class="py-3 px-4 text-center">
                                @if($hwAvg !== null)
                                    <span class="inline-flex items-center justify-center text-xs font-bold px-2 py-0.5 rounded-md {{ $hwAvg >= 70 ? 'bg-emerald-50 text-emerald-600' : ($hwAvg >= 50 ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                        {{ $hwAvg }}%
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center font-bold text-slate-800">{{ $g->total_score }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-7 text-xs font-bold rounded-lg {{ in_array($g->grade, ['A','B']) ? 'bg-emerald-100 text-emerald-700' : ($g->grade === 'C' ? 'bg-blue-100 text-blue-700' : ($g->grade === 'D' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')) }}">
                                    {{ $g->grade }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('school.grades.edit', $g) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('school.grades.destroy', $g) }}" onsubmit="return confirm('Delete this grade?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No grades found</p>
                                    <p class="text-xs text-slate-400 mt-1">Get started by adding a new grade.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($grades->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $grades->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection