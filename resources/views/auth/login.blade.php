<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Sign In</title>
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
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .animate-float { animation: float 4s ease-in-out infinite; }
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

        <!-- Hero Image -->
        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&h=1200&fit=crop" 
             alt="Students in a modern classroom" 
             class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-luminosity">

        <div class="relative z-10 flex flex-col justify-between p-12 xl:p-16 text-white w-full">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 animate-fade-up">
                                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                    <span class="text-white font-extrabold text-sm">ES</span>
                </div>
                <span class="text-xl font-extrabold tracking-tight">EASYSOLVE</span>
            </a>

            <!-- Middle: Headline + Image card -->
            <div class="animate-fade-up" style="animation-delay: 0.15s;">
                <h2 class="text-3xl xl:text-4xl font-extrabold leading-tight tracking-tight max-w-md">
                    The complete platform for modern school management.
                </h2>
                <p class="text-brand-100/70 mt-4 max-w-md text-base">
                    Manage students, attendance, grades, fees, and parent communication — all in one place.
                </p>

                <!-- Stats Card -->
                <div class="mt-8 flex items-center gap-6 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-5 max-w-md">
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
                        <p class="text-2xl font-extrabold text-white">99.9%</p>
                        <p class="text-xs text-brand-200/70 mt-0.5">Uptime</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial -->
            <div class="animate-fade-up" style="animation-delay: 0.3s;">
                <div class="flex items-center gap-1 mb-3">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-brand-100/80 text-sm leading-relaxed max-w-md">"EASYSOLVE transformed our school's administration. Fee collection, attendance, grading — everything is now effortless."</p>
                <div class="flex items-center gap-3 mt-4">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=64&h=64&fit=crop&crop=face" class="w-10 h-10 rounded-full object-cover border-2 border-white/20" alt="Adaeze Okonkwo">
                    <div>
                        <p class="text-white text-sm font-semibold">Adaeze Okonkwo</p>
                        <p class="text-brand-200/60 text-xs">Principal, Greenfield Academy</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== RIGHT: FORM PANEL ====== -->
    <div class="w-full lg:w-1/2 flex flex-col bg-gray-50">
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md animate-fade-up">
            <!-- Mobile Logo (visible on small screens) -->
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
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome back</h1>
                <p class="text-slate-500 mt-2">Sign in to your EASYSOLVE account to continue.</p>
            </div>

            <!-- Error Summary -->
            @if ($errors->any())
                <div class="shake bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-start gap-3 mb-6">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="font-semibold text-sm">Invalid credentials</p>
                        <p class="text-sm mt-0.5">The email or password you entered is incorrect.</p>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <form method="POST" action="{{ route('login') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-5">

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

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200' }} rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none input-focus transition">
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-600 transition">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 transition">
                        <span class="text-sm text-slate-600">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-brand-600 hover:text-brand-700 font-semibold transition">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Sign In</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </button>
            </form>

            <!-- Register link -->
            <p class="text-center text-sm text-slate-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-brand-600 hover:text-brand-700 font-semibold transition">Create one</a>
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

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
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