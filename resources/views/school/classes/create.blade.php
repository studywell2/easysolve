@extends('layouts.school')

@section('title', 'Add Class')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.classes.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Classes
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Add Class</h1>
            <p class="text-sm text-slate-400 mt-0.5">Create a new class with sections</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-3xl">
            <form method="POST" action="{{ route('school.classes.store') }}">
                @csrf
                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Class Name <span class="text-red-400">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. JSS 1" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                            <select id="status" name="status" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
                        <input type="text" id="description" name="description" value="{{ old('description') }}" placeholder="Optional description" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-sm font-semibold text-slate-700">Sections</label>
                            <button type="button" onclick="addSection()" class="text-sm text-brand-600 hover:text-brand-700 font-semibold transition">+ Add Section</button>
                        </div>
                        <div id="sections-container" class="space-y-3">
                            <div class="section-row flex items-center gap-3">
                                <input type="text" name="sections[0][name]" placeholder="Section name (e.g. A)" class="w-32 px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                <input type="number" name="sections[0][capacity]" placeholder="Capacity" value="40" min="1" class="w-28 px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                                <button type="button" onclick="removeSection(this)" class="text-red-400 hover:text-red-600 p-1 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Create Class
                    </button>
                    <a href="{{ route('school.classes.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let sectionIndex = 1;
        function addSection() {
            const container = document.getElementById('sections-container');
            const row = document.createElement('div');
            row.className = 'section-row flex items-center gap-3';
            row.innerHTML = `
                <input type="text" name="sections[${sectionIndex}][name]" placeholder="Section name" class="w-32 px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                <input type="number" name="sections[${sectionIndex}][capacity]" placeholder="Capacity" value="40" min="1" class="w-28 px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                <button type="button" onclick="removeSection(this)" class="text-red-400 hover:text-red-600 p-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            container.appendChild(row);
            sectionIndex++;
        }
        function removeSection(btn) {
            const rows = document.querySelectorAll('.section-row');
            if (rows.length > 1) btn.closest('.section-row').remove();
        }
    </script>
    @endpush
@endsection