<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Pricing & Plans</title>
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
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp 0.5s ease-out both; }
        .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 40%, #3b82f6 80%, #60a5fa 100%); }
        .grid-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .toggle-bg { background: linear-gradient(90deg, #2563eb 50%, #e5e7eb 50%); }
        input:checked + .toggle-slider { background: #2563eb; }
        input:checked + .toggle-slider .toggle-knob { transform: translateX(24px); }
        .toggle-slider { transition: background 0.3s; }
        .toggle-knob { transition: transform 0.3s; }
    </style>
</head>
<body class="min-h-screen font-sans bg-gray-50">

    <!-- ====== NAVBAR ====== -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/25">
                    <span class="text-white font-extrabold text-sm">ES</span>
                </div>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">EASYSOLVE</span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition">Sign in</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 px-4 py-2 rounded-xl shadow-lg shadow-brand-600/20 transition">Get started</a>
            </div>
        </div>
    </nav>

    <!-- ====== HERO ====== -->
    <div class="relative overflow-hidden hero-gradient">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 bg-indigo-400/15 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center text-white">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-6 animate-fade-up">
                <svg class="w-4 h-4 text-brand-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="text-xs font-semibold text-brand-100">Simple, transparent pricing</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight animate-fade-up" style="animation-delay: 0.1s;">
                Plans for every school size
            </h1>
            <p class="text-brand-100/70 mt-4 text-lg max-w-2xl mx-auto animate-fade-up" style="animation-delay: 0.15s;">
                Start free with a 14-day trial. No credit card required. Cancel anytime.
            </p>
        </div>
    </div>

    <!-- ====== PRICING CARDS ====== -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20 pb-20">
        @if($plans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white rounded-2xl border {{ $plan->is_popular ? 'border-brand-300 ring-2 ring-brand-500/20 shadow-xl shadow-brand-500/10' : 'border-gray-200 shadow-lg shadow-slate-200/50' }} overflow-hidden animate-fade-up" style="animation-delay: {{ ($loop->index * 0.1) }}s">
                        @if($plan->is_popular)
                            <div class="bg-gradient-to-r from-brand-600 to-indigo-600 px-6 py-2.5 text-center">
                                <span class="text-[11px] font-bold text-white uppercase tracking-wider">⭐ Most Popular</span>
                            </div>
                        @endif

                        <div class="p-6 sm:p-8">
                            <!-- Plan Name -->
                            <h3 class="text-xl font-extrabold text-slate-900">{{ $plan->name }}</h3>
                            @if($plan->description)
                                <p class="text-sm text-slate-500 mt-1">{{ $plan->description }}</p>
                            @endif

                            <!-- Price -->
                            <div class="mt-6 flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-slate-900">{{ $plan->formatted_monthly }}</span>
                                <span class="text-sm text-slate-400">/month</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">or {{ $plan->formatted_yearly }}/year</p>

                            <!-- CTA -->
                            <a href="{{ route('register') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 {{ $plan->is_popular ? 'bg-brand-600 hover:bg-brand-700 text-white shadow-lg shadow-brand-600/25' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} font-semibold py-3 px-6 rounded-xl transition-all duration-200 text-sm">
                                Start free trial
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>

                            <!-- Features List -->
                            <div class="mt-8 space-y-3">
                                <!-- Limits -->
                                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $plan->max_students ? 'Up to ' . $plan->max_students . ' students' : 'Unlimited students' }}
                                </div>
                                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $plan->max_staff ? 'Up to ' . $plan->max_staff . ' staff' : 'Unlimited staff' }}
                                </div>

                                <!-- Custom Features -->
                                @if($plan->features)
                                    @foreach($plan->features as $feature)
                                        <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $feature }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-sm font-semibold text-slate-400">No plans available yet</p>
                <p class="text-xs text-slate-300 mt-1">Please check back soon</p>
            </div>
        @endif
    </div>

    <!-- ====== FAQ / TRUST SECTION ====== -->
    <div class="bg-white border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-2xl font-extrabold text-slate-900 text-center mb-10">Frequently asked questions</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Is there a free trial?</h3>
                    <p class="text-sm text-slate-500 mt-1">Yes! Every plan starts with a 14-day free trial. No credit card required — just sign up and start managing your school.</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Can I change plans later?</h3>
                    <p class="text-sm text-slate-500 mt-1">Absolutely. You can upgrade or downgrade your plan at any time. Changes take effect immediately and we'll prorate the difference.</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">What happens when my trial ends?</h3>
                    <p class="text-sm text-slate-500 mt-1">You'll be prompted to choose a plan. If you don't subscribe, your account will be paused but your data is safe — you can reactivate anytime.</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Do you offer discounts for yearly billing?</h3>
                    <p class="text-sm text-slate-500 mt-1">Yes — yearly plans are offered at a discount compared to monthly billing. See the prices above for yearly rates.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== CTA FOOTER ====== -->
    <div class="bg-gradient-to-br from-brand-600 to-indigo-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-3xl font-extrabold text-white">Ready to get started?</h2>
            <p class="text-brand-100/80 mt-2">Join 200+ schools already using EASYSOLVE.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 mt-6 bg-white hover:bg-gray-100 text-brand-700 font-semibold px-8 py-3.5 rounded-xl shadow-xl transition-all duration-200 text-sm">
                Create your free account
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </div>

    <!-- ====== FOOTER ====== -->
    <footer class="bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-500">&copy; {{ date('Y') }} EASYSOLVE Platform. Built by WETech Technology.</span>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white transition">Home</a>
                <a href="{{ route('plans.index') }}" class="text-xs text-slate-400 hover:text-white transition">Pricing</a>
                <a href="{{ route('help') }}" class="text-xs text-slate-400 hover:text-white transition">Help</a>
            </div>
        </div>
    </footer>
</body>
</html>
