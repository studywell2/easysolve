@extends('layouts.admin')

@section('title', 'Platform Settings')
@section('subtitle', 'Configure platform-wide settings and preferences')

@section('content')
    <div class="mb-6 animate-fade-up">
        <h1 class="text-2xl font-extrabold text-slate-800">Platform Settings</h1>
        <p class="text-sm text-slate-400 mt-0.5">Manage your platform configuration</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- General Settings -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-1">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">General Settings</h3>
                            <p class="text-xs text-slate-400">Core platform configuration</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.settings.update') }}">
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

                    <div class="p-6 space-y-5">
                        <div>
                            <label for="platform_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Platform Name <span class="text-red-400">*</span></label>
                            <input type="text" id="platform_name" name="platform_name" value="{{ old('platform_name', 'EASYSOLVE') }}"
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('platform_name') ? 'border-red-300' : '' }}">
                            <p class="text-xs text-slate-400 mt-1.5">This name appears in the sidebar and page titles</p>
                            @error('platform_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="support_email" class="block text-sm font-semibold text-slate-700 mb-1.5">Support Email <span class="text-red-400">*</span></label>
                            <input type="email" id="support_email" name="support_email" value="{{ old('support_email', 'support@easysolve.com') }}"
                                class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition {{ $errors->has('support_email') ? 'border-red-300' : '' }}">
                            <p class="text-xs text-slate-400 mt-1.5">Used for notification emails and support requests</p>
                            @error('support_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    <div class="px-6 py-4 flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition-all duration-200 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Platform Info -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-fade-up delay-2">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Platform Info</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-slate-400">Version</span>
                        <span class="text-xs font-semibold text-slate-600">1.0.0</span>
                    </div>
                    <div class="border-t border-gray-50"></div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-slate-400">Environment</span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2 py-0.5 rounded-full {{ app()->environment('production') ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ app()->environment('production') ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ app()->environment() }}
                        </span>
                    </div>
                    <div class="border-t border-gray-50"></div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-slate-400">Laravel</span>
                        <span class="text-xs font-semibold text-slate-600">{{ app()->version() }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-fade-up delay-3">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.schools.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-brand-50 transition group">
                        <div class="w-8 h-8 rounded-lg bg-brand-50 group-hover:bg-brand-100 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Manage Schools</p>
                            <p class="text-[11px] text-slate-400">View & edit schools</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-emerald-50 transition group">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 group-hover:bg-emerald-100 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Dashboard</p>
                            <p class="text-[11px] text-slate-400">Platform overview</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection