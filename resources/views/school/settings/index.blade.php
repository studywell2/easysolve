@extends('layouts.school')

@section('title', 'School Settings')

@section('content')
    <div class="animate-fade-up">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">School Settings</h1>
            <p class="text-sm text-slate-400 mt-0.5">Manage your school information and configuration</p>
        </div>

        <div class="space-y-6 max-w-2xl">
            <!-- General Information -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">General Information</h3>
                            <p class="text-xs text-slate-400">Basic school details</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('school.settings.update') }}">
                    @csrf @method('PUT')

                    <div class="p-6 space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">School Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $school->name) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="short_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Short Name / Abbreviation</label>
                            <input type="text" id="short_name" name="short_name" value="{{ old('short_name', $school->short_name) }}" placeholder="e.g. GFA" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $school->email) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $school->phone) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
                            <textarea id="address" name="address" rows="2" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">{{ old('address', $school->address) }}</textarea>
                        </div>

                        <div>
                            <label for="motto" class="block text-sm font-semibold text-slate-700 mb-1.5">Motto</label>
                            <input type="text" id="motto" name="motto" value="{{ old('motto', $school->motto) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Subscription Status</label>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-50 text-emerald-600' : ($school->subscription_status === 'trial' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-500' : ($school->subscription_status === 'trial' ? 'bg-amber-500' : 'bg-red-500') }}"></span>
                                {{ ucfirst($school->subscription_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 px-6 py-4">
                        <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>

            @if(auth()->user()->isOwner())
            <!-- Terms & Conditions -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.752.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Terms & Conditions</h3>
                            <p class="text-xs text-slate-400">All users must accept the latest version</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('school.terms.update') }}">
                    @csrf @method('PUT')

                    <div class="p-6">
                        <label for="terms_and_conditions" class="block text-sm font-semibold text-slate-700 mb-1.5">Terms & Conditions Content</label>
                        <textarea id="terms_and_conditions" name="terms_and_conditions" rows="12" placeholder="Enter your school's Terms & Conditions here..." class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">{{ old('terms_and_conditions', $school->terms_and_conditions) }}</textarea>
                        @error('terms_and_conditions')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                        @if($school->terms_updated_at)
                            <p class="text-xs text-slate-400 mt-2">Last updated: {{ $school->terms_updated_at->format('F j, Y \a\t g:i A') }}</p>
                        @endif
                    </div>

                    <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Save Terms & Conditions
                        </button>
                        @if($school->terms_and_conditions)
                            <span class="text-xs text-slate-400">Saving will require all users to re-accept.</span>
                        @endif
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
@endsection