<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Terms &amp; Conditions</title>
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
        .nav-blur { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
        .mobile-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .mobile-menu.open { max-height: 500px; }
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
                <a href="{{ route('plans.index') }}" class="text-sm font-medium text-slate-600 hover:text-brand-600 transition">Pricing</a>
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
                <a href="{{ route('plans.index') }}" class="block px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-gray-50 hover:text-brand-600 transition">Pricing</a>
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

    <!-- ====== HERO HEADER ====== -->
    <div class="relative hero-gradient overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 bg-indigo-400/15 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="animate-fade-up" style="animation-delay: 0.1s;">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-xs font-semibold text-brand-100 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Legal
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">Terms &amp; Conditions</h1>
                <p class="text-brand-100/70 mt-3 max-w-lg text-base">Terms of service, acceptable use policies, and privacy practices governing your use of EASYSOLVE.</p>
                <p class="text-xs text-brand-200/60 mt-4">Last updated: {{ date('F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- ====== CONTENT ====== -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-20">
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/60 border border-gray-100 p-6 sm:p-10 animate-fade-up">

            <!-- ====== TABLE OF CONTENTS ====== -->
            <div class="mb-10 p-5 bg-brand-50/50 rounded-xl border border-brand-100">
                <h3 class="text-xs font-bold text-brand-700 uppercase tracking-wider mb-3">Table of Contents</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5 text-sm">
                    <a href="#terms" class="text-brand-600 hover:text-brand-800 transition flex items-center gap-2"><span class="text-brand-400">01</span> Terms &amp; Conditions</a>
                    <a href="#privacy" class="text-brand-600 hover:text-brand-800 transition flex items-center gap-2"><span class="text-brand-400">02</span> Privacy Policy</a>
                </div>
            </div>

            <!-- ====== SECTION 1: TERMS & CONDITIONS ====== -->
            <section id="terms" class="mb-12 scroll-mt-20">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 bg-brand-100 rounded-lg flex items-center justify-center text-brand-700 font-bold text-sm">01</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Terms &amp; Conditions</h2>
                </div>

                <div class="space-y-6 text-sm text-slate-600 leading-relaxed">
                    <!-- 1. Acceptance of Terms -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">1. Acceptance of Terms</h3>
                        <p>By accessing or using the EASYSOLVE platform ("Service"), you agree to be bound by these Terms and Conditions ("Terms"). If you do not agree with any part of these Terms, you must discontinue use of the Service immediately. These Terms constitute a legally binding agreement between you ("User") and EASYSOLVE.</p>
                        <p class="mt-2">EASYSOLVE reserves the right to modify these Terms at any time. Continued use of the Service following any changes constitutes acceptance of the revised Terms. It is your responsibility to review these Terms periodically.</p>
                    </div>

                    <!-- 2. Subscription & Payments -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">2. Subscription &amp; Payments</h3>
                        <ul class="space-y-1.5 ml-1">
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> EASYSOLVE operates on a monthly subscription basis. Access to the Service is granted only upon successful payment of the applicable subscription fee.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> The current monthly subscription fee is &#8358;10,000, subject to change with prior notice.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> All payments are processed through authorized payment gateways. EASYSOLVE does not store or retain your payment card details.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> Failure to renew your subscription by the due date will result in automatic suspension of access to the Service until payment is made.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> Subscription fees are non-refundable except where expressly required by applicable law or at the sole discretion of EASYSOLVE.</li>
                        </ul>
                    </div>

                    <!-- 3. User Accounts -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">3. User Accounts</h3>
                        <p>To access the Service, you must register an account. You agree to:</p>
                        <ul class="space-y-1.5 ml-1 mt-2">
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> Provide accurate, complete, and current information during registration.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> Maintain the security and confidentiality of your login credentials at all times.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> Accept full responsibility for all activities that occur under your account.</li>
                            <li class="flex items-start gap-2"><span class="text-brand-500 mt-0.5">•</span> Notify EASYSOLVE immediately of any unauthorized access or use of your account.</li>
                        </ul>
                        <p class="mt-2">EASYSOLVE shall not be liable for any loss or damage arising from your failure to comply with these obligations.</p>
                    </div>

                    <!-- 4. Acceptable Use -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">4. Acceptable Use Policy</h3>
                        <p class="mb-2">You agree not to engage in any of the following prohibited activities:</p>
                        <div class="p-3 bg-red-50/50 rounded-lg border border-red-100">
                            <ul class="space-y-1.5">
                                <li class="flex items-start gap-2"><span class="text-red-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span> Attempting to gain unauthorized access to any part of the Service, other user accounts, or systems.</li>
                                <li class="flex items-start gap-2"><span class="text-red-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span> Sharing, transferring, or selling your account credentials to any third party.</li>
                                <li class="flex items-start gap-2"><span class="text-red-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span> Using the Service for any unlawful purpose or in violation of any applicable laws or regulations.</li>
                                <li class="flex items-start gap-2"><span class="text-red-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span> Interfering with or disrupting the integrity or performance of the Service.</li>
                                <li class="flex items-start gap-2"><span class="text-red-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span> Reverse engineering, decompiling, or attempting to extract the source code of the Service.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 5. Service Availability -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">5. Service Availability</h3>
                        <p>EASYSOLVE strives to provide continuous and uninterrupted access to the Service. However, the Service is provided on an "as is" and "as available" basis. We do not guarantee that the Service will be uninterrupted, error-free, or free of harmful components. Scheduled maintenance, emergency repairs, or circumstances beyond our control may result in temporary interruptions.</p>
                    </div>

                    <!-- 6. Intellectual Property -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">6. Intellectual Property</h3>
                        <p>All content, software, design, logos, and other materials displayed on the Service are the exclusive property of EASYSOLVE or its licensors and are protected by applicable intellectual property laws. No part of the Service may be reproduced, distributed, or transmitted without the prior written consent of EASYSOLVE.</p>
                    </div>

                    <!-- 7. Limitation of Liability -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">7. Limitation of Liability</h3>
                        <p>To the fullest extent permitted by applicable law, EASYSOLVE shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of data, loss of profits, or business interruption, arising out of or in connection with your use of the Service.</p>
                    </div>

                    <!-- 8. Termination -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">8. Account Termination</h3>
                        <p>EASYSOLVE reserves the right to suspend or terminate your account, without prior notice, for any violation of these Terms or for conduct that we reasonably believe is harmful to the Service, other users, or third parties. Upon termination, your right to access the Service will immediately cease.</p>
                        <p class="mt-2">You may terminate your account at any time by contacting our support team. Upon termination, any outstanding subscription fees remain due and payable.</p>
                    </div>

                    <!-- 9. Governing Law -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">9. Governing Law</h3>
                        <p>These Terms shall be governed by and construed in accordance with the laws of the Federal Republic of Nigeria. Any disputes arising under these Terms shall be subject to the exclusive jurisdiction of the competent courts in Nigeria.</p>
                    </div>

                    <!-- 10. Contact -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">10. Contact</h3>
                        <p>If you have any questions or concerns regarding these Terms, please contact us through our <a href="{{ route('help') }}" class="text-brand-600 hover:text-brand-700 font-semibold transition">support page</a>.</p>
                    </div>
                </div>
            </section>

            <div class="border-t border-gray-100 my-10"></div>

            <!-- ====== SECTION 2: PRIVACY POLICY ====== -->
            <section id="privacy" class="mb-6 scroll-mt-20">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-700 font-bold text-sm">02</span>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Privacy Policy</h2>
                </div>

                <div class="space-y-6 text-sm text-slate-600 leading-relaxed">
                    <!-- Data Collection -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">Information We Collect</h3>
                        <p>We collect personal information that you provide during registration and use of the Service, including:</p>
                        <ul class="space-y-1.5 ml-1 mt-2">
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Full name and email address</li>
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Account authentication credentials</li>
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Payment and subscription records</li>
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Usage data and platform interaction logs</li>
                        </ul>
                    </div>

                    <!-- Data Use -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">How We Use Your Information</h3>
                        <p>Your information is used solely for the following purposes:</p>
                        <ul class="space-y-1.5 ml-1 mt-2">
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Authenticating your identity and securing your account</li>
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Processing and managing your subscription</li>
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Providing customer support and resolving issues</li>
                            <li class="flex items-start gap-2"><span class="text-emerald-500 mt-0.5">•</span> Improving the Service through usage analytics</li>
                        </ul>
                    </div>

                    <!-- Data Protection -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">Data Protection &amp; Sharing</h3>
                        <div class="p-5 bg-emerald-50/50 rounded-xl border border-emerald-100">
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <span class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                                    <span>We do not sell, rent, or trade your personal information to third parties under any circumstances.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                                    <span>Data is shared only with authorized payment processors as strictly necessary to complete subscription transactions.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                                    <span>All personal data is encrypted and stored securely using industry-standard security measures.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-6 h-6 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                                    <span>We may disclose information if required by law or to protect the rights and safety of EASYSOLVE and its users.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Data Retention -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">Data Retention</h3>
                        <p>We retain your personal information only for as long as your account is active or as needed to provide the Service. Upon account termination, we will delete your personal data within a reasonable period, except where retention is required by law for record-keeping purposes.</p>
                    </div>

                    <!-- Your Rights -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-1.5">Your Rights</h3>
                        <p>You have the right to access, correct, or delete your personal information at any time. To exercise these rights, please contact us through our <a href="{{ route('help') }}" class="text-brand-600 hover:text-brand-700 font-semibold transition">support page</a>.</p>
                    </div>
                </div>
            </section>

            <!-- Back to home -->
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-gray-100">
                <a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-slate-600 inline-flex items-center gap-1.5 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    Back to home
                </a>
                <a href="{{ route('help') }}" class="text-sm text-brand-600 hover:text-brand-700 font-semibold inline-flex items-center gap-1.5 transition">
                    Need help? Contact us
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
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
                    <div class="flex items-center gap-3 mt-6">
                        <a href="mailto:studywellmail1@gmail.com" class="w-9 h-9 bg-white/5 hover:bg-red-600 rounded-lg flex items-center justify-center transition group" title="Gmail">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/></svg>
                        </a>
                        <a href="https://linkedin.com/in/studywell" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-white/5 hover:bg-blue-700 rounded-lg flex items-center justify-center transition group" title="LinkedIn">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="https://wa.me/2349130710906" target="_blank" rel="noopener noreferrer" class="w-9 h-9 bg-white/5 hover:bg-green-600 rounded-lg flex items-center justify-center transition group" title="WhatsApp">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.515 5.255l-.999 3.648 3.474-.837zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
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