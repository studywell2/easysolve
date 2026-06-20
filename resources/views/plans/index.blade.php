<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Pricing &amp; Plans</title>
    <meta name="description" content="Simple, transparent pricing for every school size. Start free with a 14-day trial. No credit card required.">
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
        .nav-blur { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }

        /* FAQ Accordion */
        .faq-item { transition: all 0.3s ease; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .faq-item.active .faq-answer { max-height: 300px; }
        .faq-item.active .faq-chevron { transform: rotate(180deg); }
        .faq-chevron { transition: transform 0.3s ease; }

        /* Mobile menu */
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .mobile-menu.open { max-height: 500px; }

        /* Pricing card hover */
        .pricing-card { transition: all 0.3s ease; }
        .pricing-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body class="min-h-screen font-sans bg-gray-50">

    <!-- ====== NAVBAR ====== -->
    <nav id="navbar" class="sticky top-0 z-50 nav-blur bg-white/80 border-b border-gray-200/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/25">
                    <span class="text-white font-extrabold text-sm">ES</span>
                </div>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">EASYSOLVE</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}#services" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Features</a>
                <a href="{{ route('home') }}#why-choose" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Why Us</a>
                <a href="{{ route('home') }}#built-for" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Solutions</a>
                <a href="{{ route('home') }}#faq" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">FAQ</a>
                <a href="{{ route('plans.index') }}" class="text-sm font-semibold text-brand-600">Pricing</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="hidden sm:inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-block text-sm font-semibold text-slate-600 hover:text-brand-600 transition">Sign in</a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition">
                        Get started
                    </a>
                @endauth
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="mobile-menu md:hidden bg-white border-t border-gray-100">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}#services" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Features</a>
                <a href="{{ route('home') }}#why-choose" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Why Us</a>
                <a href="{{ route('home') }}#built-for" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Solutions</a>
                <a href="{{ route('home') }}#faq" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">FAQ</a>
                <div class="pt-3 border-t border-gray-100 mt-3 flex flex-col gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-center bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-center border border-gray-200 text-slate-600 text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-gray-50 transition">Sign in</a>
                        <a href="{{ route('register') }}" class="text-center bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Get started</a>
                    @endauth
                </div>
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
                    <div class="pricing-card bg-white rounded-2xl border {{ $plan->is_popular ? 'border-brand-300 ring-2 ring-brand-500/20 shadow-xl shadow-brand-500/10' : 'border-gray-200 shadow-lg shadow-slate-200/50' }} overflow-hidden animate-fade-up" style="animation-delay: {{ ($loop->index * 0.1) }}s">
                        @if($plan->is_popular)
                            <div class="bg-gradient-to-r from-brand-600 to-indigo-600 px-6 py-2.5 text-center">
                                <span class="text-[11px] font-bold text-white uppercase tracking-wider">&#11088; Most Popular</span>
                            </div>
                        @endif

                        <div class="p-6 sm:p-8">
                            <h3 class="text-xl font-extrabold text-slate-900">{{ $plan->name }}</h3>
                            @if($plan->description)
                                <p class="text-sm text-slate-500 mt-1">{{ $plan->description }}</p>
                            @endif

                            <div class="mt-6 flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-slate-900">{{ $plan->formatted_monthly }}</span>
                                <span class="text-sm text-slate-400">/month</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">or {{ $plan->formatted_yearly }}/year</p>

                            <a href="{{ route('register') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 {{ $plan->is_popular ? 'bg-brand-600 hover:bg-brand-700 text-white shadow-lg shadow-brand-600/25' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} font-semibold py-3 px-6 rounded-xl transition-all duration-200 text-sm">
                                Start free trial
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>

                            <div class="mt-8 space-y-3">
                                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $plan->max_students ? 'Up to ' . $plan->max_students . ' students' : 'Unlimited students' }}
                                </div>
                                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $plan->max_staff ? 'Up to ' . $plan->max_staff . ' staff' : 'Unlimited staff' }}
                                </div>

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

    <!-- ====== COMPARISON / TRUST SECTION ====== -->
    <section class="bg-white border-t border-gray-100 py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">14-Day Free Trial</p>
                    <p class="text-xs text-slate-400 mt-1">No credit card required</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Cancel Anytime</p>
                    <p class="text-xs text-slate-400 mt-1">No long-term contracts</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Yearly Discount</p>
                    <p class="text-xs text-slate-400 mt-1">Save on annual billing</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-6.856-.095c-1.141.028-2.022.566-2.022 1.676v3.5c0 .304.05.59.14.855"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">24/7 Support</p>
                    <p class="text-xs text-slate-400 mt-1">We're always here</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== FAQ ACCORDION ====== -->
    <section class="py-16 lg:py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 text-xs font-bold px-4 py-2 rounded-full mb-4 uppercase tracking-wider">FAQ</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Frequently asked questions</h2>
            </div>

            <div class="space-y-4">
                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Is there a free trial?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Yes! Every plan starts with a 14-day free trial. No credit card required — just sign up and start managing your school.</p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Can I change plans later?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Absolutely. You can upgrade or downgrade your plan at any time. Changes take effect immediately and we'll prorate the difference.</p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">What happens when my trial ends?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">You'll be prompted to choose a plan. If you don't subscribe, your account will be paused but your data is safe — you can reactivate anytime.</p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">Do you offer discounts for yearly billing?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">Yes — yearly plans are offered at a discount compared to monthly billing. See the prices above for yearly rates.</p>
                    </div>
                </div>

                <div class="faq-item bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFAQ(this)" class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-bold text-slate-800">What payment methods do you accept?</span>
                        <svg class="faq-chevron w-5 h-5 text-slate-400 flex-shrink-0 ml-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <p class="px-6 pb-5 text-sm text-slate-500 leading-relaxed">We accept bank transfers and payments through our secure platform. Once your payment is verified, your subscription is activated immediately.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2 md:col-span-3 lg:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-extrabold text-sm">ES</span>
                        </div>
                        <span class="text-xl font-extrabold text-white">EASYSOLVE</span>
                    </div>
                    <p class="text-sm leading-relaxed">The complete school management platform for modern schools.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Platform</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}#services" class="hover:text-white transition">Features</a></li>
                        <li><a href="{{ route('home') }}#why-choose" class="hover:text-white transition">Why Us</a></li>
                        <li><a href="{{ route('plans.index') }}" class="hover:text-white transition">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Resources</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('help') }}" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="{{ route('home') }}#faq" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition">Terms</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Get Started</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Create Account</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} EASYSOLVE. All rights reserved.</p>
                <p class="text-xs text-slate-500 flex items-center gap-1.5">Built by <span class="font-semibold text-brand-400">WETech Technology</span></p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('open');
        }

        function toggleFAQ(button) {
            const item = button.parentElement;
            const wasActive = item.classList.contains('active');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
            if (!wasActive) {
                item.classList.add('active');
            }
        }

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