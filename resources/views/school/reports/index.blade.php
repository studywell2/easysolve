@extends('layouts.school')

@section('title', 'Reports & Analytics')

@section('content')
    <div class="animate-fade-up">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Reports & Analytics</h1>
            <p class="text-sm text-slate-500 mt-1">Insights and summaries across your school</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Enrollment Summary -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Enrollment Summary</h2>
                </div>
                <div class="space-y-3">
                    @foreach(['owner' => 'Owners', 'admin' => 'Admins', 'teacher' => 'Teachers', 'student' => 'Students', 'parent' => 'Parents'] as $role => $label)
                    <div class="flex items-center justify-between p-2.5 rounded-lg hover:bg-gray-50/50 transition">
                        <span class="text-sm text-slate-600">{{ $label }}</span>
                        <span class="text-sm font-bold text-slate-800">{{ $enrollment[$role] ?? 0 }}</span>
                    </div>
                    @endforeach
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-sm font-semibold text-slate-800">Total</span>
                        <span class="text-sm font-extrabold text-slate-900">{{ $enrollment->sum() }}</span>
                    </div>
                </div>
            </div>

            <!-- Attendance Summary -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Attendance Summary</h2>
                </div>
                <div class="space-y-3">
                    @foreach(['present' => 'Present', 'absent' => 'Absent', 'late' => 'Late', 'excused' => 'Excused'] as $status => $label)
                    <div class="flex items-center justify-between p-2.5 rounded-lg hover:bg-gray-50/50 transition">
                        <span class="text-sm text-slate-600">{{ $label }}</span>
                        <span class="text-sm font-bold text-slate-800">{{ $attendanceSummary[$status] ?? 0 }}</span>
                    </div>
                    @endforeach
                    @php($totalAtt = $attendanceSummary->sum())
                    @if($totalAtt > 0)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs text-slate-400">Distribution</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden flex">
                            @foreach(['present' => 'bg-emerald-500', 'late' => 'bg-amber-500', 'excused' => 'bg-blue-500', 'absent' => 'bg-red-500'] as $s => $color)
                            @if(($attendanceSummary[$s] ?? 0) > 0)
                            <div class="{{ $color }}" style="width: {{ round(($attendanceSummary[$s] / $totalAtt) * 100) }}%"></div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25"/></svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Financial Summary</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-xl">
                        <span class="text-sm text-slate-500">Total Fees Expected</span>
                        <span class="text-lg font-extrabold text-slate-900">₦{{ number_format($totalFees) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-emerald-50/50 rounded-xl">
                        <span class="text-sm text-emerald-600">Total Collected</span>
                        <span class="text-lg font-extrabold text-emerald-700">₦{{ number_format($totalPaid) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-xl">
                        <span class="text-sm text-red-600">Outstanding</span>
                        <span class="text-lg font-extrabold text-red-700">₦{{ number_format($totalOutstanding) }}</span>
                    </div>
                    @if($totalFees > 0)
                    <div class="pt-2">
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all" style="width: {{ min(100, round(($totalPaid / $totalFees) * 100)) }}%"></div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 text-center">{{ round(($totalPaid / $totalFees) * 100) }}% collection rate</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Grade Distribution -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800">Grade Distribution</h2>
                </div>
                @php($gradeColors = ['A' => 'bg-emerald-500', 'B' => 'bg-blue-500', 'C' => 'bg-brand-500', 'D' => 'bg-amber-500', 'E' => 'bg-orange-500', 'F' => 'bg-red-500'])
                @php($totalGrades = $gradeDistribution->sum())
                <div class="space-y-3">
                    @foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $g)
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-7 h-7 text-xs font-bold rounded-lg {{ in_array($g, ['A','B']) ? 'bg-emerald-100 text-emerald-700' : ($g === 'C' ? 'bg-blue-100 text-blue-700' : ($g === 'D' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')) }}">{{ $g }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-4 overflow-hidden">
                            @if($totalGrades > 0 && ($gradeDistribution[$g] ?? 0) > 0)
                            <div class="{{ $gradeColors[$g] }} h-full rounded-full transition-all" style="width: {{ round(($gradeDistribution[$g] / $totalGrades) * 100) }}%"></div>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-slate-600 w-8 text-right">{{ $gradeDistribution[$g] ?? 0 }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection