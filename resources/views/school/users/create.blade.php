@extends('layouts.school')

@section('title', 'Add User')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Users
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Add New User</h1>
            <p class="text-sm text-slate-400 mt-0.5">Create a new teacher, student, parent, or admin</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.users.store') }}" class="space-y-6">
                @csrf

                <!-- Basic Info -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-1.5">First Name <span class="text-red-400">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('first_name') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name <span class="text-red-400">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('last_name') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-400">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('email') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-red-400">*</span></label>
                        <select id="role" name="role" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('role') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">Select role</option>
                            <option value="admin" {{ old('role', request('role')) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="teacher" {{ old('role', request('role')) === 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="student" {{ old('role', request('role')) === 'student' ? 'selected' : '' }}>Student</option>
                            <option value="parent" {{ old('role', request('role')) === 'parent' ? 'selected' : '' }}>Parent</option>
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="border-t border-gray-100"></div>

                <!-- Student Fields -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="class_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Class</label>
                            <select id="class_id" name="class_id" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <option value="">Select class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" data-sections="{{ $class->sections->toJson() }}" {{ old('class_id', request('class_id')) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
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
                </div>

                <div id="parent-field" class="{{ (old('role', request('role')) === 'student') ? '' : 'hidden' }}">
                    <label for="parent_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Assign Parent/Guardian</label>
                    <select id="parent_id" name="parent_id" class="w-full px-4 py-2.5 bg-gray-50/80 border {{ $errors->has('parent_id') ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        <option value="">Select parent/guardian</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->full_name }} ({{ $p->email }})</option>
                        @endforeach
                    </select>
                    @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="subjects-field" class="{{ (old('role', request('role')) === 'student') ? '' : 'hidden' }} space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Offered Subjects</label>
                    @if($subjects->count())
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-48 overflow-y-auto bg-gray-50/80 rounded-xl p-3 border border-gray-200">
                            @foreach($subjects as $subject)
                                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer hover:bg-gray-100 rounded-lg px-2 py-1.5 transition">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                                    {{ $subject->name }}
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400">No subjects available. Add subjects first.</p>
                    @endif
                </div>

                <div class="border-t border-gray-100"></div>

                <!-- Auto-generated Password Notice -->
                <div class="p-4 rounded-xl bg-brand-50 border border-brand-100">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-brand-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5a2.25 2.25 0 012.25 2.25v6.75a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25v-6.75a2.25 2.25 0 012.25-2.25z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-brand-700">A secure temporary password will be auto-generated</p>
                            <p class="text-xs text-brand-600 mt-0.5">The user will receive their password via email. They will be prompted to change it on first login.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Create User
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
            if (!isStudent) {
                document.getElementById('parent_id').value = '';
                document.querySelectorAll('#subjects-field input[type="checkbox"]').forEach(cb => cb.checked = false);
            }
        }

        roleSelect.addEventListener('change', toggleStudentFields);

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
                sectionSelect.appendChild(option);
            });
        });

        document.getElementById('class_id').dispatchEvent(new Event('change'));
    </script>
@endsection