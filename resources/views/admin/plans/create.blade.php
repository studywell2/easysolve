@extends('layouts.admin')

@section('title', 'Create Plan')
@section('subtitle', 'Add a new subscription plan')

@section('content')
    <!-- Back Link -->
    <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4 animate-fade-up">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Plans
    </a>

    <div class="flex items-center gap-3 mb-6 animate-fade-up">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center border border-brand-100/50">
            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Create Plan</h1>
            <p class="text-sm text-slate-400">Define pricing, limits, and features</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm max-w-2xl animate-fade-up delay-1">
        <form method="POST" action="{{ route('admin.plans.store') }}">
            @csrf

            @if ($errors->any())
                <div class="mx-6 mt-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="font-semibold text-sm">Please fix the errors below</p>
                        <ul class="list-disc list-inside text-sm mt-1 space-y-0.5">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Section: Basic Info -->
            <div class="px-6 pt-6 pb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Basic Information</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Plan Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Starter, Growth, Premium"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('name') ? 'border-red-300 bg-red-50/50' : '' }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-semibold text-slate-700 mb-1.5">Slug <span class="text-slate-400 font-normal">(auto-generated if blank)</span></label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="starter"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('slug') ? 'border-red-300 bg-red-50/50' : '' }}">
                        @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
                        <textarea id="description" name="description" rows="2" placeholder="A short summary of this plan"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Section: Pricing -->
            <div class="px-6 pt-4 pb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Pricing (₦)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="price_monthly" class="block text-sm font-semibold text-slate-700 mb-1.5">Monthly Price <span class="text-red-400">*</span></label>
                        <input type="number" id="price_monthly" name="price_monthly" value="{{ old('price_monthly', '0') }}" step="0.01" min="0"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('price_monthly') ? 'border-red-300 bg-red-50/50' : '' }}">
                        @error('price_monthly') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="price_yearly" class="block text-sm font-semibold text-slate-700 mb-1.5">Yearly Price <span class="text-red-400">*</span></label>
                        <input type="number" id="price_yearly" name="price_yearly" value="{{ old('price_yearly', '0') }}" step="0.01" min="0"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('price_yearly') ? 'border-red-300 bg-red-50/50' : '' }}">
                        @error('price_yearly') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Section: Limits -->
            <div class="px-6 pt-4 pb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Limits <span class="text-slate-300 font-normal normal-case">(leave blank for unlimited)</span></h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="max_students" class="block text-sm font-semibold text-slate-700 mb-1.5">Max Students</label>
                        <input type="number" id="max_students" name="max_students" value="{{ old('max_students') }}" min="0" placeholder="Unlimited"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    </div>
                    <div>
                        <label for="max_staff" class="block text-sm font-semibold text-slate-700 mb-1.5">Max Staff</label>
                        <input type="number" id="max_staff" name="max_staff" value="{{ old('max_staff') }}" min="0" placeholder="Unlimited"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Section: Features -->
            <div class="px-6 pt-4 pb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Features <span class="text-slate-300 font-normal normal-case">(one per line)</span></h3>
                <textarea id="features" name="features" rows="6" placeholder="Up to 500 students&#10;Attendance tracking&#10;Grade management&#10;Fee collection"
                    class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none font-mono">{{ old('features') }}</textarea>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Section: Options -->
            <div class="px-6 pt-4 pb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Display Options</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Mark as Most Popular</p>
                            <p class="text-xs text-slate-400">Highlights this plan on the pricing page</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Active</p>
                            <p class="text-xs text-slate-400">Inactive plans are hidden from the pricing page</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Actions -->
            <div class="px-6 py-5 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition-all duration-200 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Create Plan
                </button>
                <a href="{{ route('admin.plans.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
            </div>
        </form>
    </div>
@endsection
