<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful — EASYSOLVE</title>
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
        @keyframes checkmark { 0% { stroke-dashoffset: 50; } 100% { stroke-dashoffset: 0; } }
        @keyframes scale-up { 0% { transform: scale(0); opacity: 0; } 50% { transform: scale(1.15); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .animate-check { animation: checkmark 0.5s ease-out 0.3s both; }
        .animate-circle { animation: scale-up 0.4s ease-out both; }
        .animate-fade-up { animation: fadeUp 0.5s ease-out both; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 40%, #3b82f6 80%, #60a5fa 100%); }
        .grid-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
    </style>
</head>
<body class="h-screen overflow-hidden font-sans flex">

    <!-- ====== LEFT: IMAGE PANEL ====== -->
    <div class="hidden lg:flex lg:w-1/2 relative hero-gradient">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 bg-brand-400/15 rounded-full blur-3xl"></div>

        <img src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?w=800&h=1200&fit=crop" 
             alt="Graduation celebration" 
             class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">

        <div class="relative z-10 flex flex-col justify-between p-12 xl:p-16 text-white w-full">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 animate-fade-up">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                    <span class="text-white font-extrabold text-sm">ES</span>
                </div>
                <span class="text-xl font-extrabold tracking-tight">EASYSOLVE</span>
            </a>

            <div class="animate-fade-up" style="animation-delay: 0.15s;">
                <div class="inline-flex items-center gap-2 bg-emerald-400/20 backdrop-blur-sm border border-emerald-400/30 text-emerald-300 text-xs font-bold px-4 py-2 rounded-full mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    Welcome to the family!
                </div>
                <h2 class="text-3xl xl:text-4xl font-extrabold leading-tight tracking-tight max-w-md">
                    You're all set to transform your school.
                </h2>
                <p class="text-brand-100/70 mt-4 max-w-md text-base">
                    Your EASYSOLVE account has been created. Sign in to access your dashboard and start managing your school with ease.
                </p>

                <!-- Next Steps -->
                <div class="mt-8 space-y-4 max-w-md">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/10 flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-white">1</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Sign in to your account</p>
                            <p class="text-xs text-brand-200/60 mt-0.5">Use your email and password to access the dashboard.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/10 flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-white">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Set up classes & subjects</p>
                            <p class="text-xs text-brand-200/60 mt-0.5">Create your academic structure — classes, sections, and subjects.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/10 flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-white">3</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Add students & teachers</p>
                            <p class="text-xs text-brand-200/60 mt-0.5">Enroll students and invite staff to join your portal.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom stats -->
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

    <!-- ====== RIGHT: SUCCESS CARD ====== -->
    <div class="w-full lg:w-1/2 flex flex-col bg-gray-50">
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-lg animate-fade-up">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/25">
                        <span class="text-white font-extrabold text-sm">ES</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">EASYSOLVE</span>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sm:p-10 text-center">

                <!-- Animated Checkmark -->
                <div class="animate-circle inline-flex items-center justify-center w-20 h-20 bg-emerald-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path class="animate-check" stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" style="stroke-dasharray: 50; stroke-dashoffset: 0;"/>
                    </svg>
                </div>

                <h1 class="text-2xl font-extrabold text-slate-900">Account Created!</h1>
                <p class="text-slate-500 mt-2">Your EASYSOLVE account has been set up successfully.</p>

                <!-- School Info Card -->
                <div class="mt-6 bg-gray-50 rounded-xl p-5 text-left">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 bg-brand-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-700">School</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">Name</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $school->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">Email</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $school->email ?? 'Not set' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">Plan</span>
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-700">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                {{ ucfirst($school->subscription_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- User Info Card -->
                <div class="mt-4 bg-gray-50 rounded-xl p-5 text-left">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-700">Account</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">Name</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->first_name }} {{ $user->last_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">Email</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Role</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ $user->role === 'owner' ? 'bg-brand-100 text-brand-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 space-y-3">
                    <a href="{{ route('login') }}"
                       class="w-full bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Sign In Now</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="{{ route('register') }}"
                       class="w-full border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium py-3 px-6 rounded-xl transition flex items-center justify-center gap-2">
                        Register Another School
                    </a>
                </div>
            </div>

            <!-- Back to home -->
            <p class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 inline-flex items-center gap-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    Back to home
                </a>
            </p>
        </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-200/60 bg-white/50 px-6 py-4 flex-shrink-0">
            <div class="max-w-lg mx-auto flex items-center justify-between text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} EASYSOLVE</span>
                <span class="flex items-center gap-1.5">Built by <span class="font-semibold text-brand-600">WETech Technology</span></span>
            </div>
        </footer>
    </div>
</body>
</html>