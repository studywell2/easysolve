@extends('layouts.admin')

@section('title', 'Edit School')
@section('subtitle', "Update {$school->name} details")

@section('content')
    <!-- Back Link -->
    <a href="{{ route('admin.schools.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4 animate-fade-up">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Schools
    </a>

    <div class="flex items-center gap-3 mb-6 animate-fade-up">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center text-brand-600 font-bold text-sm border border-brand-100/50">
            {{ strtoupper(substr($school->name, 0, 2)) }}
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Edit {{ $school->name }}</h1>
            <p class="text-sm text-slate-400">Update school information and settings</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm max-w-2xl animate-fade-up delay-1">
        <form method="POST" action="{{ route('admin.schools.update', $school) }}">
            @csrf @method('PUT')

            @if ($errors->any())
                <div class="mx-6 mt-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
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
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">School Name <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $school->name) }}"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('name') ? 'border-red-300 bg-red-50/50' : '' }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $school->email) }}"
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $school->phone) }}"
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Section: Subscription -->
            <div class="px-6 pt-4 pb-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Subscription</h3>
                <div class="space-y-4">
                    <div>
                        <label for="plan_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Plan</label>
                        <select id="plan_id" name="plan_id"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="">— No plan assigned —</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_id', $school->plan_id) == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} ({{ $plan->formatted_monthly }}/mo)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="subscription_status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status <span class="text-red-400">*</span></label>
                        <select id="subscription_status" name="subscription_status"
                            class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="trial" {{ old('subscription_status', $school->subscription_status) === 'trial' ? 'selected' : '' }}>🟡 Trial</option>
                            <option value="active" {{ old('subscription_status', $school->subscription_status) === 'active' ? 'selected' : '' }}>🟢 Active</option>
                            <option value="expired" {{ old('subscription_status', $school->subscription_status) === 'expired' ? 'selected' : '' }}>🔴 Expired</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Actions -->
            <div class="px-6 py-5 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition-all duration-200 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.schools.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
            </div>
        </form>
    </div>
@endsection