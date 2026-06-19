@extends('layouts.school')

@section('title', 'Edit User')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Users
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Edit User</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $user->full_name }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.users.update', $user) }}" class="space-y-6">
                @csrf @method('PUT')

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-1.5">First Name <span class="text-red-400">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('first_name') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name <span class="text-red-400">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('last_name') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('email') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-red-400">*</span></label>
                        <select id="role" name="role" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('role') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @foreach(['admin','teacher','student','parent'] as $r)
                                <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="border-t border-gray-100"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                        <select id="class_id" name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" data-sections="{{ $class->sections->toJson() }}" {{ old('class_id', $user->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="section_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Section</label>
                        <select id="section_id" name="section_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select section</option>
                        </select>
                    </div>
                </div>

                <div id="parent-field" class="{{ old('role', $user->role) === 'student' ? '' : 'hidden' }}">
                    <label for="parent_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Assign Parent/Guardian</label>
                    <select id="parent_id" name="parent_id" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('parent_id') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        <option value="">Select parent/guardian</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}" {{ old('parent_id', $user->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->full_name }} ({{ $p->email }})</option>
                        @endforeach
                    </select>
                    @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="subjects-field" class="{{ old('role', $user->role) === 'student' ? '' : 'hidden' }} space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Offered Subjects</label>
                    @php $selectedSubjects = old('subjects', $user->subjects->pluck('id')->toArray()) @endphp
                    @if($subjects->count())
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-48 overflow-y-auto bg-gray-50/80 rounded-xl p-3 border border-gray-200">
                            @foreach($subjects as $subject)
                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer hover:bg-gray-100 rounded-lg px-2 py-1.5 transition">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" {{ in_array($subject->id, $selectedSubjects) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                                    {{ $subject->name }}
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400">No subjects available. Add subjects first.</p>
                    @endif
                </div>

                <div class="border-t border-gray-100"></div>

                <div>
                    <p class="text-sm text-slate-500 mb-3">Leave password fields blank to keep current password (min 8 characters if setting new)</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">New Password</label>
                            <input type="password" id="password" name="password" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('password') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Update User
                    </button>
                    <a href="{{ route('school.users.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const parentField = document.getElementById('parent-field');
        const subjectsField = document.getElementById('subjects-field');

        function toggleStudentFields() {
            const isStudent = roleSelect.value === 'student';
            parentField.classList.toggle('hidden', !isStudent);
            subjectsField.classList.toggle('hidden', !isStudent);
        }

        roleSelect.addEventListener('change', toggleStudentFields);

        const currentSectionId = '{{ old('section_id', $user->section_id) }}';

        document.getElementById('class_id').addEventListener('change', function () {
            const sectionSelect = document.getElementById('section_id');
            const selectedOption = this.options[this.selectedIndex];
            sectionSelect.innerHTML = '<option value="">Select section</option>';

            if (!this.value || !selectedOption.dataset.sections) return;

            const sections = JSON.parse(selectedOption.dataset.sections);
            sections.forEach(function (section) {
                const option = document.createElement('option');
                option.value = section.id;
                option.textContent = section.name;
                if (section.id == currentSectionId) option.selected = true;
                sectionSelect.appendChild(option);
            });
        });

        document.getElementById('class_id').dispatchEvent(new Event('change'));
    </script>
@endsection