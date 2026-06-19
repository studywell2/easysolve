<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Reset Password</title>
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
<body class="h-screen overflow-hidden font-sans flex">

    <!-- ====== LEFT: IMAGE PANEL (hidden on mobile) ====== -->
    <div class="hidden lg:flex lg:w-1/2 relative hero-gradient">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 bg-indigo-400/15 rounded-full blur-3xl"></div>

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
                <div class="inline-flex items-center gap-2 bg-white/5 backdrop-blur-md border border-white/10 rounded-full px-4 py-2 mb-6">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    <span class="text-xs font-semibold text-brand-100">Secure Password Reset</span>
                </div>
                <h2 class="text-3xl xl:text-4xl font-extrabold leading-tight tracking-tight max-w-md">
                    Forgot your password? No worries.
                </h2>
                <p class="text-brand-100/70 mt-4 max-w-md text-base">
                    Enter your email address and we'll send you a secure link to reset your password and regain access to your account.
                </p>
            </div>

            <!-- Trust indicators -->
            <div class="animate-fade-up" style="animation-delay: 0.3s;">
                <div class="flex items-center gap-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 max-w-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm text-brand-100/90">Encrypted &amp; secure</span>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm text-brand-100/90">Link expires in 60 min</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== RIGHT: FORM PANEL ====== -->
    <div class="w-full lg:w-1/2 flex flex-col bg-gray-50">
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md animate-fade-up">
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
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Reset password</h1>
                <p class="text-slate-500 mt-2">Enter your email and we'll send you a link to reset your password.</p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 flex items-start gap-3 mb-6 animate-fade-up">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold text-sm">Check your email</p>
                        <p class="text-sm mt-0.5">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Summary -->
            @if ($errors->any())
                <div class="shake bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3 mb-6">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="font-semibold text-sm">Something went wrong</p>
                        <ul class="list-disc list-inside text-sm mt-1 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <form method="POST" action="{{ route('password.email') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-5">

                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Send Reset Link</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.75 14.25m0-4.5l5.25-5.25M6 12h12.75m0 0L16.5 9.75m2.25 2.25l-2.25 2.25"/></svg>
                </button>
            </form>

            <!-- Back to login -->
            <p class="text-center text-sm text-slate-500 mt-6">
                Remember your password?
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
            <div class="max-w-md mx-auto flex items-center justify-between text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} EASYSOLVE</span>
                <span class="flex items-center gap-1.5">Built by <span class="font-semibold text-brand-600">WETech Technology</span></span>
            </div>
        </footer>
    </div>
</body>
</html>
