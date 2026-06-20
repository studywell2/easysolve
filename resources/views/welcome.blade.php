<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — School Management Platform</title>
    <meta name="description" content="EASYSOLVE is a modern school management platform that simplifies administration, attendance, grading, fee collection, and parent communication.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                        },
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.3); } 50% { box-shadow: 0 0 0 8px rgba(59,130,246,0); } }
        .animate-fade-up { animation: fadeUp 0.6s ease-out both; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulseGlow 2.5s ease-in-out infinite; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 40%, #3b82f6 70%, #60a5fa 100%); }
        .grid-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .feature-card { transition: all 0.3s ease; }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(37,99,235,0.15); }
        .nav-blur { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }

        /* FAQ Accordion */
        .faq-item { transition: all 0.3s ease; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .faq-item.active .faq-answer { max-height: 300px; }
        .faq-item.active .faq-chevron { transform: rotate(180deg); }
        .faq-chevron { transition: transform 0.3s ease; }

        /* School-type tabs */
        .tab-btn { transition: all 0.2s ease; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeUp 0.4s ease-out both; }

        /* Mobile menu */
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .mobile-menu.open { max-height: 500px; }

        /* Service card hover */
        .service-card { transition: all 0.3s ease; }
        .service-card:hover { border-color: #bfdbfe; box-shadow: 0 12px 32px -8px rgba(37,99,235,0.12); }
        .service-card:hover .service-icon { transform: scale(1.1); }
        .service-icon { transition: transform 0.3s ease; }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-white">

    <!-- ====== NAVBAR ====== -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 nav-blur bg-white/80 border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/25">
                        <span class="text-white font-extrabold text-sm">ES</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">EASYSOLVE</span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#services" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Features</a>
                    <a href="#why-choose" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Why Us</a>
                    <a href="#built-for" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Solutions</a>
                    <a href="#testimonials" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Reviews</a>
                    <a href="#faq" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">FAQ</a>
                    <a href="{{ route('plans.index') }}" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Pricing</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hidden sm:inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
                            Dashboard
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-block text-sm font-semibold text-slate-600 hover:text-brand-600 transition">Log in</a>
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
                            Get Started
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @endauth
                    <!-- Mobile hamburger -->
                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-gray-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu md:hidden bg-white border-t border-gray-100">
            <div class="px-4 py-4 space-y-1">
                <a href="#services" onclick="toggleMobileMenu()" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Features</a>
                <a href="#why-choose" onclick="toggleMobileMenu()" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Why Us</a>
                <a href="#built-for" onclick="toggleMobileMenu()" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Solutions</a>
                <a href="#testimonials" onclick="toggleMobileMenu()" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Reviews</a>
                <a href="#faq" onclick="toggleMobileMenu()" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">FAQ</a>
                <a href="{{ route('plans.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Pricing</a>
                <div class="pt-3 border-t border-gray-100 mt-3 flex flex-col gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-center bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-center border border-gray-200 text-slate-600 text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-gray-50 transition">Log in</a>
                        <a href="{{ route('register') }}" class="text-center bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ====== HERO SECTION ====== -->
    <section class="relative hero-gradient pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-50"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-400/15 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Content -->
                <div class="text-center lg:text-left animate-fade-up">
                    <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-brand-200 text-xs font-semibold px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        Nigeria's #1 School Management Platform
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] tracking-tight">
                        Manage your school
                        <span class="block bg-gradient-to-r from-brand-200 to-indigo-200 bg-clip-text text-transparent">the smart way.</span>
                    </h1>
                    <p class="text-lg text-brand-100/80 mt-6 max-w-xl mx-auto lg:mx-0">
                        From enrollment to graduation — EASYSOLVE brings your entire school operations into one beautiful platform. Manage students, track attendance, record grades, collect fees, and communicate with parents effortlessly.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center lg:justify-start">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-brand-50 text-brand-700 font-bold px-8 py-4 rounded-xl shadow-2xl shadow-black/20 transition-all duration-200 hover:scale-[1.02]">
                                Go to Dashboard
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-brand-50 text-brand-700 font-bold px-8 py-4 rounded-xl shadow-2xl shadow-black/20 transition-all duration-200 hover:scale-[1.02]">
                                Start Free Trial
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-xl border border-white/20 transition-all duration-200">
                                Sign In
                            </a>
                        @endauth
                    </div>
                    <div class="flex items-center gap-6 mt-10 justify-center lg:justify-start">
                        <div class="flex -space-x-3">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=64&h=64&fit=crop&crop=face" class="w-10 h-10 rounded-full border-2 border-white/60 object-cover" alt="User">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=64&h=64&fit=crop&crop=face" class="w-10 h-10 rounded-full border-2 border-white/60 object-cover" alt="User">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=64&h=64&fit=crop&crop=face" class="w-10 h-10 rounded-full border-2 border-white/60 object-cover" alt="User">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=64&h=64&fit=crop&crop=face" class="w-10 h-10 rounded-full border-2 border-white/60 object-cover" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-white/60 bg-brand-500 flex items-center justify-center text-white text-xs font-bold">200+</div>
                        </div>
                        <div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-xs text-brand-200 mt-0.5">Rated 4.9/5 by 200+ school administrators</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Hero Image with Floating Cards -->
                <div class="relative animate-fade-up delay-2">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-black/30">
                        <img src="https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=800&h=600&fit=crop" alt="Students learning in a modern classroom" class="w-full h-[400px] lg:h-[500px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-900/40 via-transparent to-transparent"></div>
                    </div>

                    <!-- Floating Card: Attendance -->
                    <div class="absolute -left-4 lg:-left-8 top-12 bg-white rounded-2xl shadow-2xl p-4 w-52 animate-float">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Today's Attendance</p>
                                <p class="text-lg font-extrabold text-slate-800">96.5%</p>
                            </div>
                        </div>
                        <div class="mt-3 w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: 96.5%"></div>
                        </div>
                    </div>

                    <!-- Floating Card: Revenue -->
                    <div class="absolute -right-4 lg:-right-8 bottom-12 bg-white rounded-2xl shadow-2xl p-4 w-52 animate-float" style="animation-delay: 1s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium">Fees Collected</p>
                                <p class="text-lg font-extrabold text-slate-800">&#8358;4.2M</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.5-5.75a.75.75 0 011.08 0l5.5 5.75a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd"/></svg>
                            <span class="text-xs font-semibold text-emerald-600">+12.5%</span>
                            <span class="text-xs text-slate-400">vs last term</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full"><path d="M0 80L60 70C120 60 240 40 360 35C480 30 600 40 720 45C840 50 960 50 1080 45C1200 40 1320 30 1380 25L1440 20V80H0Z" fill="white"/></svg>
        </div>
    </section>

    <!-- ====== TRUSTED BY / LOGO STRIP ====== -->
    <section class="py-12 bg-white border-b border-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">Trusted by leading schools and institutions across Africa</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-8 items-center opacity-60">
                <div class="text-center font-bold text-slate-400 text-lg">Greenfield Academy</div>
                <div class="text-center font-bold text-slate-400 text-lg">St. Mary's College</div>
                <div class="text-center font-bold text-slate-400 text-lg">Riverside School</div>
                <div class="text-center font-bold text-slate-400 text-lg">Horizon Institute</div>
                <div class="text-center font-bold text-slate-400 text-lg">Blossom Heights</div>
                <div class="text-center font-bold text-slate-400 text-lg">Legacy Academy</div>
            </div>
        </div>
    </section>

    <!-- ====== SERVICE CARDS WITH PRICING ====== -->
    <section id="services" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">Our Solutions</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Everything your school needs, in one platform</h2>
                <p class="text-lg text-slate-500 mt-4">From your first student to a thriving institution, EASYSOLVE gives you everything you need to succeed.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Student Management -->
                <div class="service-card group bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="service-icon w-14 h-14 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl flex items-center justify-center shadow-lg shadow-brand-500/25 mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Student Management</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Enroll students, assign classes, manage parent links, and maintain complete digital profiles for every student.</p>
                    <p class="text-sm font-bold text-brand-600">From &#8358;2,500/mo</p>
                </div>

                <!-- Attendance Tracking -->
                <div class="service-card group bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="service-icon w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/25 mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Attendance Tracking</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Mark daily attendance in seconds. Track present, absent, and late records with automated rate calculations.</p>
                    <p class="text-sm font-bold text-brand-600">Included in all plans</p>
                </div>

                <!-- Grade Management -->
                <div class="service-card group bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="service-icon w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/25 mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Grade &amp; Result Management</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Record continuous assessment and exam scores. Generate professional report cards with automatic grade calculations.</p>
                    <p class="text-sm font-bold text-brand-600">Included in all plans</p>
                </div>

                <!-- Fee Collection -->
                <div class="service-card group bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="service-icon w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/25 mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Fee Collection &amp; Payments</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Set up fee structures per class and term. Record payments, track outstanding balances, and generate financial reports.</p>
                    <p class="text-sm font-bold text-brand-600">From &#8358;2,500/mo</p>
                </div>

                <!-- Communication -->
                <div class="service-card group bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="service-icon w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/25 mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.294 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v.51z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Parent Communication</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Send announcements, messages, and updates. Parents can monitor attendance, grades, and payment history in real time.</p>
                    <p class="text-sm font-bold text-brand-600">Included in all plans</p>
                </div>

                <!-- Reports & Analytics -->
                <div class="service-card group bg-white rounded-2xl border border-gray-200 p-8">
                    <div class="service-icon w-14 h-14 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25 mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Reports &amp; Analytics</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">Get instant insights into attendance trends, fee collection rates, and student performance with real-time dashboards.</p>
                    <p class="text-sm font-bold text-brand-600">From &#8358;3,500/mo</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== WHY CHOOSE EASYSOLVE ====== -->
    <section id="why-choose" class="py-20 lg:py-28 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">Why Choose Us</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Over 200+ schools trust EASYSOLVE</h2>
                <p class="text-lg text-slate-500 mt-4">Over the years, schools and institutions across Africa have trusted us to deliver excellent services.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="feature-card bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-19.199l-3.114.732a9 9 0 01-6.086-.71l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Nigeria's #1 School Platform</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">We are Nigeria's leading and most popular school management platform, supporting schools for years and counting.</p>
                </div>

                <!-- Card 2 -->
                <div class="feature-card bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5M3.75 3h16.5M3.75 15a1.5 1.5 0 010 3M20.25 15a1.5 1.5 0 010 3M3.75 9a1.5 1.5 0 010-3M20.25 9a1.5 1.5 0 010-3"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">All-in-One Solution</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">With our growing number of offerings, we are your one-stop shop for everything your school needs to succeed.</p>
                </div>

                <!-- Card 3 -->
                <div class="feature-card bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-6.856-.095c-1.141.028-2.022.566-2.022 1.676v3.5c0 .304.05.59.14.855M5.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-6.856-.095c-1.141.028-2.022.566-2.022 1.676v3.5c0 .304.05.59.14.855"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">24/7 Customer Support</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Our award-winning support team is available to handle any requests you may have. Whatever you need, we're just a click away.</p>
                </div>

                <!-- Card 4 -->
                <div class="feature-card bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Affordability</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">We believe in providing cost-effective solutions. Enjoy competitive prices without compromising on quality.</p>
                </div>

                <!-- Card 5 -->
                <div class="feature-card bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Reliability &amp; Security</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Trust is the foundation of our services. Experience unparalleled uptime and top-notch security for your school's data.</p>
                </div>

                <!-- Card 6 -->
                <div class="feature-card bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Intuitive Interface</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Our platform, designed with the user in mind, is simple. Manage your school effortlessly, even if you're a beginner.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== BUILT FOR EVERY SCHOOL (TABS) ====== -->
    <section id="built-for" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">Solutions</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Built for every kind of school</h2>
                <p class="text-lg text-slate-500 mt-4">See the features that matter most for your school, whether you're just starting or scaling an institution.</p>
            </div>

            <!-- Tab Buttons -->
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                <button onclick="switchTab('small')" id="tab-small" class="tab-btn active px-5 py-2.5 rounded-xl text-sm font-semibold bg-brand-600 text-white shadow-lg shadow-brand-600/20">
                    For Small Schools
                </button>
                <button onclick="switchTab('large')" id="tab-large" class="tab-btn px-5 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-slate-600 hover:bg-gray-200">
                    For Large Institutions
                </button>
                <button onclick="switchTab('teachers')" id="tab-teachers" class="tab-btn px-5 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-slate-600 hover:bg-gray-200">
                    For Teachers
                </button>
                <button onclick="switchTab('parents')" id="tab-parents" class="tab-btn px-5 py-2.5 rounded-xl text-sm font-semibold bg-gray-100 text-slate-600 hover:bg-gray-200">
                    For Parents
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="max-w-4xl mx-auto">
                <!-- Small Schools -->
                <div id="content-small" class="tab-content active">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Free 14-day trial</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Easy setup in minutes</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Affordable monthly plans</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Parent portal included</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">No credit card required</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Dedicated onboarding</span>
                        </div>
                    </div>
                </div>

                <!-- Large Institutions -->
                <div id="content-large" class="tab-content">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Unlimited students &amp; staff</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Multi-campus support</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Advanced analytics &amp; reporting</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Role-based access control</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Custom report cards</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Priority support</span>
                        </div>
                    </div>
                </div>

                <!-- Teachers -->
                <div id="content-teachers" class="tab-content">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Mark attendance in seconds</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Record grades from your phone</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">View your timetable</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Message parents directly</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Generate class reports</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Track staff attendance</span>
                        </div>
                    </div>
                </div>

                <!-- Parents -->
                <div id="content-parents" class="tab-content">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Monitor attendance in real time</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">View grades &amp; report cards</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Track fee payments &amp; balances</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Receive school announcements</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Message teachers directly</span>
                        </div>
                        <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-5">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg></div>
                            <span class="text-sm font-medium text-slate-700">Multiple children, one account</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== STATS SECTION ====== -->
    <section class="py-20 lg:py-28 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Numbers that speak for themselves</h2>
                <p class="text-lg text-slate-400 mt-4">Join hundreds of schools already transforming their operations with EASYSOLVE.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <p class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-brand-400 to-indigo-400 bg-clip-text text-transparent">200+</p>
                    <p class="text-sm text-slate-400 mt-2 font-medium">Schools onboarded</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">50K+</p>
                    <p class="text-sm text-slate-400 mt-2 font-medium">Students managed</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-amber-400 to-orange-400 bg-clip-text text-transparent">&#8358;2B+</p>
                    <p class="text-sm text-slate-400 mt-2 font-medium">Fees processed</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-purple-400 to-violet-400 bg-clip-text text-transparent">99.9%</p>
                    <p class="text-sm text-slate-400 mt-2 font-medium">Uptime guaranteed</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== SECURITY & RELIABILITY ====== -->
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">Security &amp; Reliability</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Everything your school needs to stay fast, secure, and reliable</h2>
                <p class="text-lg text-slate-500 mt-4">Your school runs on fast, reliable, and secure infrastructure designed to keep it performing at its best.</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Speed & Performance -->
                <div class="bg-gradient-to-br from-brand-50 to-indigo-50 rounded-3xl p-8 border border-brand-100">
                    <div class="w-12 h-12 bg-brand-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 14.25H3.75z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Built for Speed &amp; Uptime</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg></div>
                            <div>
                                <h4 class="font-semibold text-slate-800 text-sm">Cloud Infrastructure</h4>
                                <p class="text-sm text-slate-500 mt-0.5">Hosted on reliable cloud servers for faster loading times and stable connections.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div>
                                <h4 class="font-semibold text-slate-800 text-sm">99.9% Uptime SLA</h4>
                                <p class="text-sm text-slate-500 mt-0.5">A 99.9% uptime guarantee to keep your school's platform online and accessible.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg></div>
                            <div>
                                <h4 class="font-semibold text-slate-800 text-sm">Performance Optimised</h4>
                                <p class="text-sm text-slate-500 mt-0.5">Servers optimised for speed and smooth, consistent performance.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security & Protection -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-8 border border-emerald-100">
                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Secure &amp; Protected</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg></div>
                            <div>
                                <h4 class="font-semibold text-slate-800 text-sm">Data Encryption</h4>
                                <p class="text-sm text-slate-500 mt-0.5">Your school's data is encrypted and accessible only to authorized users.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div>
                                <h4 class="font-semibold text-slate-800 text-sm">Daily Backups</h4>
                                <p class="text-sm text-slate-500 mt-0.5">Regular automatic backups to help you restore your data quickly if needed.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg></div>
                            <div>
                                <h4 class="font-semibold text-slate-800 text-sm">Role-Based Access</h4>
                                <p class="text-sm text-slate-500 mt-0.5">Owners, admins, teachers, students, and parents — each gets tailored access.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== TESTIMONIALS ====== -->
    <section id="testimonials" class="py-20 lg:py-28 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">Testimonials</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Our customers love using EASYSOLVE</h2>
                <p class="text-lg text-slate-500 mt-4">We support thousands of educators, administrators, and parents every day.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm feature-card">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">"EASYSOLVE has completely transformed how we manage our school. Fee collection used to take weeks — now it's done in days. The parent portal alone is worth every naira."</p>
                    <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=80&h=80&fit=crop&crop=face" class="w-12 h-12 rounded-full object-cover" alt="Adaeze Okonkwo">
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">Adaeze Okonkwo</p>
                            <p class="text-xs text-slate-400">Principal, Greenfield Academy</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm feature-card">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">"As a teacher, marking attendance and recording grades used to be a nightmare of paperwork. Now I do everything from my phone in minutes. The interface is beautiful and intuitive."</p>
                    <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                        <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?w=80&h=80&fit=crop&crop=face" class="w-12 h-12 rounded-full object-cover" alt="Emeka Nwosu">
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">Emeka Nwosu</p>
                            <p class="text-xs text-slate-400">Senior Teacher, St. Mary's College</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm feature-card">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">"As a parent, I love being able to check my daughter's attendance and grades in real time. No more waiting for end-of-term report cards. EASYSOLVE keeps me connected to her education."</p>
                    <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                        <img src="https://images.unsplash.com/photo-1542909168-82c3e7fdca5c?w=80&h=80&fit=crop&crop=face" class="w-12 h-12 rounded-full object-cover" alt="Fatima Bello">
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">Fatima Bello</p>
                            <p class="text-xs text-slate-400">Parent, Riverside School</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== SUPPORT SECTION ====== -->
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">Support</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Got questions? We'd love to hear from you</h2>
                <p class="text-lg text-slate-500 mt-4">Our support team is always here to help you succeed.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Help Center -->
                <a href="{{ route('help') }}" class="feature-card bg-gradient-to-br from-brand-50 to-indigo-50 rounded-2xl p-8 border border-brand-100 text-center">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-brand-500/10">
                        <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Help Center</h3>
                    <p class="text-sm text-slate-500">Have an issue but like learning on your own? We have dedicated help articles for you.</p>
                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-brand-600 mt-4">Fix it yourself <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg></span>
                </a>

                <!-- Email Support -->
                <a href="mailto:studywellmail1@gmail.com" class="feature-card bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-8 border border-emerald-100 text-center">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-500/10">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Email Support</h3>
                    <p class="text-sm text-slate-500">Whatever your question, we will respond within 24 hours all year round.</p>
                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 mt-4">Open a ticket <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg></span>
                </a>

                <!-- Chat Support -->
                <a href="https://wa.me/2349130710906" target="_blank" rel="noopener noreferrer" class="feature-card bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-8 border border-amber-100 text-center">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-amber-500/10">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.294 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v6.01z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Chat Support</h3>
                    <p class="text-sm text-slate-500">We are always here to help you. 24/7 — 365 days a year on WhatsApp.</p>
                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-amber-600 mt-4">Start chatting <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg></span>
                </a>
            </div>
        </div>
    </section>

    <!-- ====== FAQ ACCORDION ====== -->
    <section id="faq" class="py-20 lg:py-28 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">FAQ</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Frequently asked questions</h2>
                <p class="text-lg text-slate-500 mt-4">Everything you need to know about EASYSOLVE.</p>
            </div>

            <div class="space-y-4" id="faq-container">
                <!-- FAQ 1 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">What is EASYSOLVE and why do I need it?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">EASYSOLVE is a complete school management platform. It's how you manage students, track attendance, record grades, collect fees, and communicate with parents — all in one place. Whether you're running a small school or a large institution, EASYSOLVE is the first step to streamlining your administration.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Is there a free trial?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Yes! Every plan starts with a 14-day free trial. No credit card required — just sign up and start managing your school immediately.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Can I change plans later?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Absolutely. You can upgrade or downgrade your plan at any time. Changes take effect immediately and we'll prorate the difference.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">What happens when my trial ends?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">You'll be prompted to choose a plan. If you don't subscribe, your account will be paused but your data is safe — you can reactivate anytime.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Is my school's data secure?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Yes. Your school's data is encrypted, backed up daily, and accessible only to authorized users. We use role-based access control so owners, admins, teachers, students, and parents each see only what they need to.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Do you offer discounts for yearly billing?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Yes — yearly plans are offered at a discount compared to monthly billing. See our <a href="{{ route('plans.index') }}" class="text-brand-600 font-semibold hover:underline">pricing page</a> for yearly rates.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Can parents access the platform?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Yes! Parents get their own portal where they can monitor their children's attendance, grades, fee payments, and receive school announcements — all in real time.</p>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Do I need to install anything?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">No. EASYSOLVE is a cloud-based platform. You and your staff can access it from any web browser on your computer, tablet, or phone. There's nothing to install or maintain.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CTA SECTION ====== -->
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl hero-gradient p-8 sm:p-12 lg:p-16 text-center">
                <div class="absolute inset-0 grid-pattern opacity-30"></div>
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-brand-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-400/15 rounded-full blur-3xl"></div>
                <div class="relative">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">Ready to transform your school?</h2>
                    <p class="text-lg text-brand-100/80 mt-4 max-w-2xl mx-auto">Join hundreds of schools already using EASYSOLVE to simplify their administration. Get started in minutes — no credit card required.</p>
                    <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-brand-50 text-brand-700 font-bold px-8 py-4 rounded-xl shadow-2xl shadow-black/20 transition-all duration-200 hover:scale-[1.02]">
                                Go to Dashboard
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-brand-50 text-brand-700 font-bold px-8 py-4 rounded-xl shadow-2xl shadow-black/20 transition-all duration-200 hover:scale-[1.02]">
                                Start Free Trial
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-xl border border-white/20 transition-all duration-200">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== FOOTER ====== -->
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
                <!-- Brand -->
                <div class="col-span-2 md:col-span-3 lg:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-extrabold text-sm">ES</span>
                        </div>
                        <span class="text-xl font-extrabold text-white">EASYSOLVE</span>
                    </div>
                    <p class="text-sm leading-relaxed">The complete school management platform for modern schools. Manage students, attendance, grades, fees, and parent communication — all in one beautiful, secure platform.</p>
                    <div class="flex items-center gap-3 mt-6">
                        <a href="https://facebook.com/StudyWell" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-white/5 hover:bg-blue-600 rounded-lg flex items-center justify-center transition group" title="Facebook">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="https://linkedin.com/in/studywell" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-white/5 hover:bg-blue-700 rounded-lg flex items-center justify-center transition group" title="LinkedIn">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="https://wa.me/2349130710906" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-white/5 hover:bg-green-600 rounded-lg flex items-center justify-center transition group" title="WhatsApp">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.515 5.255l-.999 3.648 3.474-.837zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Platform -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Platform</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#services" class="hover:text-white transition">Features</a></li>
                        <li><a href="#why-choose" class="hover:text-white transition">Why Us</a></li>
                        <li><a href="#built-for" class="hover:text-white transition">Solutions</a></li>
                        <li><a href="#testimonials" class="hover:text-white transition">Reviews</a></li>
                        <li><a href="{{ route('plans.index') }}" class="hover:text-white transition">Pricing</a></li>
                    </ul>
                </div>

                <!-- Solutions -->
                <div class="hidden lg:block">
                    <h4 class="text-white font-semibold text-sm mb-4">Solutions</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#built-for" class="hover:text-white transition">For Small Schools</a></li>
                        <li><a href="#built-for" class="hover:text-white transition">For Large Institutions</a></li>
                        <li><a href="#built-for" class="hover:text-white transition">For Teachers</a></li>
                        <li><a href="#built-for" class="hover:text-white transition">For Parents</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Resources</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('help') }}" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#faq" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms &amp; Conditions</a></li>
                    </ul>
                </div>

                <!-- Get Started -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Get Started</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Create Account</a></li>
                        <li><a href="mailto:studywellmail1@gmail.com" class="hover:text-white transition">Contact Sales</a></li>
                        <li><a href="https://wa.me/2349130710906" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">WhatsApp Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} EASYSOLVE. All rights reserved.</p>
                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                    Built by
                    <span class="font-semibold text-brand-400">WETech Technology</span>
                </p>
            </div>
        </div>
    </footer>

    <script>
        // ===== Mobile Menu =====
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('open');
        }

        // ===== School-type Tabs =====
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            // Reset all tab buttons
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'bg-brand-600', 'text-white', 'shadow-lg', 'shadow-brand-600/20');
                b.classList.add('bg-gray-100', 'text-slate-600', 'hover:bg-gray-200');
            });
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.add('active');
            // Activate selected tab button
            const btn = document.getElementById('tab-' + tabName);
            btn.classList.add('active', 'bg-brand-600', 'text-white', 'shadow-lg', 'shadow-brand-600/20');
            btn.classList.remove('bg-gray-100', 'text-slate-600', 'hover:bg-gray-200');
        }

        // ===== FAQ Accordion =====
        function toggleFAQ(button) {
            const item = button.parentElement;
            const wasActive = item.classList.contains('active');
            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
            // Open clicked item if it wasn't active
            if (!wasActive) {
                item.classList.add('active');
            }
        }

        // ===== Navbar shadow on scroll =====
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>
