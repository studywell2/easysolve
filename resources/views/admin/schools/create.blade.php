@extends('layouts.admin')

@section('title', $setup ? 'Set Up New School' : 'Add School')
@section('subtitle', 'Create a new school with an owner account')

@section('content')
    <a href="{{ route('admin.schools.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4 animate-fade-up">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Schools
    </a>

    <div class="max-w-3xl">

        @if ($setup)
            {{-- Setup banner --}}
            <div class="rounded-2xl bg-gradient-to-br from-brand-600 to-indigo-700 p-6 mb-6 animate-fade-up shadow-lg shadow-brand-600/20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-white">Welcome! Let's set up your first school.</h2>
                        <p class="text-sm text-brand-100 mt-0.5">Fill in the details below to create a school and its owner account.</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.schools.store') }}" method="POST">
            @csrf

            {{-- School Details --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6 animate-fade-up delay-1">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">School Details</h3>
                            <p class="text-xs text-slate-400">Basic information about the school</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">School Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('name') border-red-300 @enderror"
                            placeholder="e.g. Bright Future Academy">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">School Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('email') border-red-300 @enderror"
                                placeholder="info@school.com">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('phone') border-red-300 @enderror"
                                placeholder="+234 800 000 0000">
                            @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
                        <textarea name="address" id="address" rows="2"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none @error('address') border-red-300 @enderror"
                            placeholder="123 Education Lane, City, State">{{ old('address') }}</textarea>
                        @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Subscription Configuration --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6 animate-fade-up delay-2">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5M3.75 3h16.5M3.75 15a1.5 1.5 0 010 3M20.25 15a1.5 1.5 0 010 3M3.75 9a1.5 1.5 0 010-3M20.25 9a1.5 1.5 0 010-3"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Subscription</h3>
                            <p class="text-xs text-slate-400">Choose a plan and trial duration</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Select Plan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach ($plans as $plan)
                                <label class="cursor-pointer">
                                    <input type="radio" name="plan_id" value="{{ $plan->id }}" {{ old('plan_id', $plan->slug === 'starter' ? $plan->id : null) ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-gray-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 transition text-center">
                                        <p class="text-sm font-semibold text-slate-800">{{ $plan->name }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $plan->formatted_monthly }}/mo</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('plan_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="trial_days" class="block text-sm font-semibold text-slate-700 mb-1.5">Trial Duration (days) <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="trial_days" id="trial_days" value="{{ old('trial_days', 14) }}" min="1" max="365" required
                                class="w-32 px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('trial_days') border-red-300 @enderror">
                            <span class="text-xs text-slate-400">School gets full access during this period</span>
                        </div>
                        @error('trial_days') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Owner Account --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6 animate-fade-up delay-3">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Owner Account</h3>
                            <p class="text-xs text-slate-400">The school's primary admin who will manage the portal</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="owner_first_name" class="block text-sm font-semibold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_first_name" id="owner_first_name" value="{{ old('owner_first_name') }}" required
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('owner_first_name') border-red-300 @enderror"
                                placeholder="John">
                            @error('owner_first_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="owner_last_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_last_name" id="owner_last_name" value="{{ old('owner_last_name') }}" required
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('owner_last_name') border-red-300 @enderror"
                                placeholder="Doe">
                            @error('owner_last_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="owner_email" class="block text-sm font-semibold text-slate-700 mb-1.5">Owner Email <span class="text-red-500">*</span></label>
                        <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}" required
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('owner_email') border-red-300 @enderror"
                            placeholder="john.doe@school.com">
                        @error('owner_email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-slate-400 mt-1.5">This email will be used to log in to the school portal.</p>
                    </div>

                    <div>
                        <label for="owner_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="owner_password" id="owner_password" required
                                class="w-full px-4 py-2.5 pr-10 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition @error('owner_password') border-red-300 @enderror"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </div>
                        @error('owner_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-slate-400 mt-1.5">Minimum 8 characters. You can share this with the owner.</p>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 animate-fade-up delay-4">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-brand-600/25 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    {{ $setup ? 'Create School' : 'Add School' }}
                </button>
                <a href="{{ route('admin.schools.index') }}" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('owner_password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L9.75 9.75m0 0L3 3m6.75 6.75l4.5 4.5M9.75 9.75L15 15m0 0l6 6m-6-6l3-3"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>';
            }
        }
    </script>
@endsection
