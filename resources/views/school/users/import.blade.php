@extends('layouts.school')

@section('title', 'Import Users')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Users
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Import Users via CSV</h1>
            <p class="text-sm text-slate-400 mt-0.5">Bulk create students, teachers, and parents</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Upload Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-base font-bold text-slate-800">Upload CSV File</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('school.users.import.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-5">
                                <div>
                                    <label for="csv_file" class="block text-sm font-semibold text-slate-700 mb-2">CSV File</label>
                                    <div class="relative border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-brand-400 hover:bg-brand-50/30 transition cursor-pointer">
                                        <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" required
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            onchange="document.getElementById('file-name').textContent = this.files[0] ? this.files[0].name : 'No file selected'">
                                        <div class="pointer-events-none">
                                            <div class="w-14 h-14 bg-brand-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600" id="file-name">Click to upload or drag & drop</p>
                                            <p class="text-xs text-slate-400 mt-1">CSV file up to 5MB</p>
                                        </div>
                                    </div>
                                    @error('csv_file')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200">
                                    <p class="text-xs text-amber-800 flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                        <span>Imported users get a default password of <strong class="font-mono">password</strong>. They should change it after first login. Existing emails are automatically skipped.</span>
                                    </p>
                                </div>

                                <div class="flex items-center gap-3 pt-2">
                                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                        Start Import
                                    </button>
                                    <a href="{{ route('school.users.import.template') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                        Download Template
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Instructions --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Required Columns</h3>
                    <ul class="space-y-2">
                        @foreach(['first_name' => 'required', 'last_name' => 'required', 'email' => 'required, unique', 'role' => 'student, teacher, admin, or parent'] as $col => $desc)
                        <li class="flex items-center gap-2 text-xs">
                            <code class="px-2 py-0.5 rounded bg-brand-50 text-brand-700 font-semibold">{{ $col }}</code>
                            <span class="text-slate-400">{{ $desc }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <h3 class="text-sm font-bold text-slate-800 mb-3 mt-5">Optional Columns</h3>
                    <ul class="space-y-2">
                        @foreach(['class_name' => 'must match existing class', 'section_name' => 'must match section in class', 'parent_email' => 'creates parent if needed'] as $col => $desc)
                        <li class="flex items-center gap-2 text-xs">
                            <code class="px-2 py-0.5 rounded bg-gray-100 text-slate-600 font-semibold">{{ $col }}</code>
                            <span class="text-slate-400">{{ $desc }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Example Row</h3>
                    <pre class="text-[11px] text-slate-500 bg-gray-50 rounded-lg p-3 overflow-x-auto">John,Doe,john@sch.com,student,JSS 1,A,parent@email.com</pre>
                </div>
            </div>
        </div>
    </div>
@endsection
