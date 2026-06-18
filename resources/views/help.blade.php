<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASYSOLVE — Help Center</title>
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
    </style>
</head>
<body class="min-h-screen font-sans bg-gray-50">

    <!-- ====== HERO HEADER ====== -->
    <div class="relative hero-gradient overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-20 w-96 h-96 bg-indigo-400/15 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-10 animate-fade-up">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                    <span class="text-white font-extrabold text-sm">ES</span>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-white">EASYSOLVE</span>
            </a>

            <div class="animate-fade-up" style="animation-delay: 0.1s;">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-xs font-semibold text-brand-100 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                    Help Center
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">How can we help you?</h1>
                <p class="text-brand-100/70 mt-3 max-w-lg text-base">Reach out to us through any of the channels below. We're here to help with any questions about EASYSOLVE.</p>
            </div>
        </div>
    </div>

    <!-- ====== CONTACT CARDS ====== -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            <!-- Email -->
            <a href="mailto:studywellmail1@gmail.com" class="group bg-white rounded-2xl shadow-lg shadow-gray-200/60 border border-gray-100 p-6 hover:shadow-xl hover:shadow-brand-100/40 hover:-translate-y-0.5 transition-all duration-200 animate-fade-up">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-brand-100 transition">
                        <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-slate-900">Email Us</h3>
                        <p class="text-xs text-slate-400 mt-0.5 mb-2">We typically reply within 24 hours</p>
                        <p class="text-sm font-semibold text-brand-600 group-hover:text-brand-700 break-all transition">studywellmail1@gmail.com</p>
                    </div>
                </div>
            </a>

            <!-- WhatsApp -->
            <a href="https://wa.me/2349130710906" target="_blank" rel="noopener noreferrer" class="group bg-white rounded-2xl shadow-lg shadow-gray-200/60 border border-gray-100 p-6 hover:shadow-xl hover:shadow-green-100/40 hover:-translate-y-0.5 transition-all duration-200 animate-fade-up" style="animation-delay: 0.05s;">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-100 transition">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.515 5.255l-.999 3.648 3.474-.837zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-slate-900">WhatsApp</h3>
                        <p class="text-xs text-slate-400 mt-0.5 mb-2">Chat with us instantly</p>
                        <p class="text-sm font-semibold text-green-600 group-hover:text-green-700 transition">09130710906</p>
                    </div>
                </div>
            </a>

            <!-- Phone 1 -->
            <a href="tel:09130710906" class="group bg-white rounded-2xl shadow-lg shadow-gray-200/60 border border-gray-100 p-6 hover:shadow-xl hover:shadow-brand-100/40 hover:-translate-y-0.5 transition-all duration-200 animate-fade-up" style="animation-delay: 0.1s;">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-100 transition">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-slate-900">Call Us</h3>
                        <p class="text-xs text-slate-400 mt-0.5 mb-2">Mon–Sat, 8am–6pm</p>
                        <p class="text-sm font-semibold text-indigo-600 group-hover:text-indigo-700 transition">09130710906</p>
                    </div>
                </div>
            </a>

            <!-- Phone 2 -->
            <a href="tel:08073866899" class="group bg-white rounded-2xl shadow-lg shadow-gray-200/60 border border-gray-100 p-6 hover:shadow-xl hover:shadow-brand-100/40 hover:-translate-y-0.5 transition-all duration-200 animate-fade-up" style="animation-delay: 0.15s;">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-purple-100 transition">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-slate-900">Alternate Line</h3>
                        <p class="text-xs text-slate-400 mt-0.5 mb-2">Available for urgent inquiries</p>
                        <p class="text-sm font-semibold text-purple-600 group-hover:text-purple-700 transition">08073866899</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 mb-16">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-6">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-5 select-none">
                        <span class="text-sm font-semibold text-slate-800">How do I create an account on EASYSOLVE?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-slate-500 leading-relaxed">Click "Create Account" on the homepage, fill in your school details, and follow the registration steps. If you need assistance, contact us via any of the channels above.</div>
                </details>
                <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-5 select-none">
                        <span class="text-sm font-semibold text-slate-800">What features are included in EASYSOLVE?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-slate-500 leading-relaxed">EASYSOLVE includes student management, attendance tracking, grade management, fee collection, payment processing, parent communication, academic session management, and comprehensive reporting.</div>
                </details>
                <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-5 select-none">
                        <span class="text-sm font-semibold text-slate-800">Is my data secure on EASYSOLVE?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-slate-500 leading-relaxed">Yes. We use secure authentication, encrypted data storage, and OTP verification to protect your information. User data is never shared with third parties.</div>
                </details>
                <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-5 select-none">
                        <span class="text-sm font-semibold text-slate-800">How do I reset my password?</span>
                        <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-slate-500 leading-relaxed">If you've forgotten your password, contact our support team via email or WhatsApp and we'll help you reset it securely.</div>
                </details>
            </div>
        </div>
    </div>

    <!-- ====== FOOTER ====== -->
    <footer class="bg-slate-900 text-slate-400 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-brand-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-extrabold text-xs">ES</span>
                    </div>
                    <span class="text-sm font-extrabold text-white">EASYSOLVE</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="https://facebook.com/Studywell" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-white/5 hover:bg-blue-600 rounded-lg flex items-center justify-center transition group" title="Facebook">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="https://linkedin.com/in/studywell" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-white/5 hover:bg-blue-700 rounded-lg flex items-center justify-center transition group" title="LinkedIn">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="https://wa.me/2349130710906" target="_blank" rel="noopener noreferrer" class="w-8 h-8 bg-white/5 hover:bg-green-600 rounded-lg flex items-center justify-center transition group" title="WhatsApp">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.515 5.255l-.999 3.648 3.474-.837zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </a>
                </div>
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} EASYSOLVE. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
