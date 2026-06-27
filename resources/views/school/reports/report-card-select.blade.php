@extends('layouts.school')

@section('title', 'Generate Report Card')

@section('content')
    <div class="animate-fade-up">
        @if($isManager)
        <a href="{{ route('school.reports.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Reports
        </a>
        @else
        <a href="{{ route('school.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Dashboard
        </a>
        @endif

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Report Card</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $isManager ? 'Download printable PDF report cards' : (isset($isStudent) && $isStudent ? 'Download your report card' : "Download your child's report card") }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Individual Report Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Individual Report Card</h3>
                            <p class="text-xs text-slate-400">{{ $isManager ? 'Single student PDF with full details' : (isset($isStudent) && $isStudent ? 'Download your PDF report card' : 'Download your child\'s PDF report card') }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('school.reports.report-card.generate') }}" target="_blank">
                        @csrf
                        <div class="space-y-4">
                            @if($isManager)
                            {{-- Manager: Class → Student selector --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                                <select id="report-class" name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Student</label>
                                <select id="report-student" name="student_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" required>
                                    <option value="">Select Student</option>
                                </select>
                            </div>
                            @else
                            @if(isset($isStudent) && $isStudent)
                            {{-- Student: Own report card, hidden student_id --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Student</label>
                                <div class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm text-slate-600">
                                    {{ $student->full_name }} — {{ $student->schoolClass?->name ?? 'No class' }}
                                </div>
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                            </div>
                            @else
                            {{-- Parent: Children dropdown --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Select Child</label>
                                <select name="student_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" required>
                                    <option value="">Select Child</option>
                                    @foreach($children as $child)
                                    <option value="{{ $child->id }}">{{ $child->full_name }} — {{ $child->schoolClass?->name ?? 'No class' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @endif
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Term</label>
                                <select name="term_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" required>
                                    <option value="">Select Term</option>
                                    @foreach($terms as $t)
                                    <option value="{{ $t->id }}">{{ $t->academicSession->name }} - {{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                Download Report Card PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Class Summary Report (Managers only) --}}
            @if($isManager)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Class Summary Report</h3>
                            <p class="text-xs text-slate-400">All students ranked by performance</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('school.reports.class-report') }}" target="_blank">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                                <select name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Term</label>
                                <select name="term_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition" required>
                                    <option value="">Select Term</option>
                                    @foreach($terms as $t)
                                    <option value="{{ $t->id }}">{{ $t->academicSession->name }} - {{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-emerald-600/20 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                Download Class Report PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            {{-- Parent: Info card --}}
            <div class="bg-gradient-to-br from-brand-50 to-indigo-50 rounded-2xl border border-brand-100 p-6 flex flex-col justify-center">
                <div class="w-12 h-12 rounded-2xl bg-brand-100 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 mb-2">About Report Cards</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Report cards contain {{ isset($isStudent) && $isStudent ? 'your' : "your child's" }} academic performance for the selected term, including subject grades, attendance summary, and class position. They are generated as PDF files you can download and print.
                </p>
                <p class="text-xs text-slate-400 mt-3">
                    If no grades appear, it means results haven't been published for that term yet. Please contact the school for more information.
                </p>
            </div>
            @endif
        </div>
    </div>

    @if($isManager)
    <script>
        // Dynamic student dropdown based on class selection
        document.getElementById('report-class').addEventListener('change', function() {
            const classId = this.value;
            const studentSelect = document.getElementById('report-student');
            studentSelect.innerHTML = '<option value="">Select Student</option>';

            if (!classId) return;

            const classData = @json($classes->mapWithKeys(fn($c) => [$c->id => $c->students->map(fn($s) => ['id' => $s->id, 'name' => $s->full_name])]));
            const students = classData[classId] || [];

            students.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.name;
                studentSelect.appendChild(opt);
            });
        });
    </script>
    @endif
@endsection