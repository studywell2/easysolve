<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd',
                            400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                            800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .input-focus:focus { box-shadow: 0 0 0 3px rgba(59,130,246,0.12); border-color: #3b82f6; }
        .shake { animation: shake 0.4s ease-in-out; }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-6px); } 75% { transform: translateX(6px); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp 0.5s ease-out both; }
        .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 40%, #3b82f6 80%, #60a5fa 100%); }
        .grid-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
    </style>
</head>
<body class="min-h-screen font-sans flex">

    <!-- ====== LEFT: IMAGE PANEL ====== -->
    <div class="hidden lg:flex lg:w-2/5 xl:w-5/12 relative hero-gradient">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 bg-indigo-400/15 rounded-full blur-3xl"></div>

        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=1200&fit=crop" 
             alt="Students collaborating" 
             class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">

        <div class="relative z-10 flex flex-col justify-between p-12 xl:p-16 text-white w-full">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 animate-fade-up">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                    <span class="text-white font-extrabold text-sm">ES</span>
                </div>
                <span class="text-xl font-extrabold tracking-tight">EASYSOLVE</span>
            </a>

            <!-- Middle -->
            <div class="animate-fade-up" style="animation-delay: 0.15s;">
                <h2 class="text-3xl xl:text-4xl font-extrabold leading-tight tracking-tight max-w-md">
                    Start managing your school the smart way.
                </h2>
                <p class="text-brand-100/70 mt-4 max-w-md text-base">
                    Join 200+ schools already using EASYSOLVE to streamline their operations. Get set up in minutes.
                </p>

                <!-- Benefits list -->
                <div class="mt-8 space-y-4 max-w-md">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/10 flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-sm text-brand-100/90">Free 30-day trial — no credit card required</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/10 flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-sm text-brand-100/90">Unlimited students, classes, and subjects</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/10 flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span class="text-sm text-brand-100/90">Dedicated onboarding & support team</span>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="animate-fade-up" style="animation-delay: 0.3s;">
                <div class="flex items-center gap-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 max-w-md">
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-white">200+</p>
                        <p class="text-xs text-brand-200/70 mt-0.5">Schools</p>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-white">50K+</p>
                        <p class="text-xs text-brand-200/70 mt-0.5">Students</p>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-2xl font-extrabold text-white">4.9/5</p>
                        <p class="text-xs text-brand-200/70 mt-0.5">Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== RIGHT: FORM PANEL ====== -->
    <div class="w-full lg:w-3/5 xl:w-7/12 flex flex-col bg-gray-50">
        <div class="flex-1 flex items-start lg:items-center justify-center p-6 sm:p-10 lg:p-12 overflow-y-auto">
        <div class="w-full max-w-2xl animate-fade-up py-8">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/25">
                        <span class="text-white font-extrabold text-sm">ES</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">EASYSOLVE</span>
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Create your account</h1>
                <p class="text-slate-500 mt-2">Get started with EASYSOLVE in minutes. No credit card required.</p>
            </div>

            <!-- Error Summary -->
            @if ($errors->any())
                <div class="shake bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3 mb-6">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="font-semibold text-sm">Please fix the errors below</p>
                        <ul class="list-disc list-inside text-sm mt-1 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <form method="POST" action="{{ route('register') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-8">

                @csrf

                <!-- SCHOOL SECTION -->
                <div>
                    <div class="flex items-center gap-2.5 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">School Information</h2>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="school_name" class="block text-sm font-semibold text-slate-700 mb-1.5">School Name <span class="text-red-400">*</span></label>
                            <input type="text" id="school_name" name="school_name" placeholder="e.g. Greenfield Academy" value="{{ old('school_name') }}"
                                class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('school_name') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                            @error('school_name')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="school_email" class="block text-sm font-semibold text-slate-700 mb-1.5">School Email</label>
                                <input type="email" id="school_email" name="school_email" placeholder="info@school.com" value="{{ old('school_email') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('school_email') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                                @error('school_email')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="school_phone" class="block text-sm font-semibold text-slate-700 mb-1.5">School Phone</label>
                                <input type="text" id="school_phone" name="school_phone" placeholder="+234 800 000 0000" value="{{ old('school_phone') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('school_phone') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                                @error('school_phone')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100"></div>

                <!-- OWNER SECTION -->
                <div>
                    <div class="flex items-center gap-2.5 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Your Information</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="owner_first_name" class="block text-sm font-semibold text-slate-700 mb-1.5">First Name <span class="text-red-400">*</span></label>
                                <input type="text" id="owner_first_name" name="owner_first_name" placeholder="Ade" value="{{ old('owner_first_name') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('owner_first_name') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                                @error('owner_first_name')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="owner_last_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name <span class="text-red-400">*</span></label>
                                <input type="text" id="owner_last_name" name="owner_last_name" placeholder="Yinka" value="{{ old('owner_last_name') }}"
                                    class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('owner_last_name') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                                @error('owner_last_name')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="owner_email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-400">*</span></label>
                            <input type="email" id="owner_email" name="owner_email" placeholder="you@example.com" value="{{ old('owner_email') }}"
                                class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('owner_email') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                            @error('owner_email')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" placeholder="Min. 6 characters"
                                        class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition pr-11">
                                    <button type="button" onclick="togglePassword('password', 'eye-icon-pw')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-600 transition">
                                        <svg id="eye-icon-pw" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password"
                                        class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition pr-11">
                                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-pwc')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-600 transition">
                                        <svg id="eye-icon-pwc" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Create Account</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </button>
            </form>

            <!-- Login link -->
            <p class="text-center text-sm text-slate-500 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-brand-600 hover:text-brand-700 font-semibold transition">Sign in</a>
            </p>

            <!-- Back to home -->
            <p class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 inline-flex items-center gap-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    Back to home
                </a>
            </p>
        </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-200/60 bg-white/50 px-6 py-4 flex-shrink-0">
            <div class="max-w-2xl mx-auto flex items-center justify-between text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} EASYSOLVE</span>
                <span class="flex items-center gap-1.5">Built by <span class="font-semibold text-brand-600">WETech Technology</span></span>
            </div>
        </footer>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>';
            }
        }
    </script>
</body>
</html>
