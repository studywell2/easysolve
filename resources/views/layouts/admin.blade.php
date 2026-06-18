<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — EASYSOLVE Admin</title>
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
                        },
                        slate: { 850: '#151f2e', 950: '#0b1120' }
                    }
                }
            }
        }
    </script>
    <style>
        /* ====== Sidebar ====== */
        .sidebar-link {
            @apply flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium transition-all duration-200 relative group/link;
        }
        .sidebar-link .sidebar-icon {
            @apply transition-all duration-200;
        }
        .sidebar-link:hover {
            @apply bg-white/[0.08] text-white;
        }
        .sidebar-link:hover .sidebar-icon {
            @apply scale-110;
        }
        .sidebar-link.active {
            @apply bg-gradient-to-r from-brand-600/25 to-brand-500/10 text-white font-semibold;
        }
        .sidebar-link.active::before {
            content: '';
            @apply absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-6 bg-brand-400 rounded-r-full shadow-lg shadow-brand-400/50;
        }
        .sidebar-link.active .sidebar-icon {
            @apply text-brand-400 drop-shadow-[0_0_6px_rgba(96,165,250,0.4)];
        }

        /* Tooltip for collapsed sidebar */
        .sidebar-collapsed .sidebar-link {
            @apply relative;
        }
        .sidebar-collapsed .sidebar-link::after {
            content: attr(data-tooltip);
            @apply absolute left-full ml-3 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-lg whitespace-nowrap opacity-0 pointer-events-none transition-opacity duration-200 shadow-xl z-[999];
        }
        .sidebar-collapsed .sidebar-link:hover::after {
            @apply opacity-100;
        }

        .sidebar-section {
            @apply text-[10px] font-bold text-slate-500 uppercase tracking-[0.12em] px-3 mb-2 mt-6 first:mt-0 flex items-center gap-3;
        }
        .sidebar-section::after {
            content: '';
            @apply flex-1 h-px bg-gradient-to-r from-slate-700/50 to-transparent;
        }

        /* Collapsed */
        .sidebar-collapsed { width: 4.75rem; }
        .sidebar-collapsed .sidebar-text { display: none; }
        .sidebar-collapsed .sidebar-section { display: none; }
        .sidebar-collapsed .sidebar-link { @apply justify-center px-0; }
        .sidebar-collapsed .sidebar-link.active::before { display: none; }
        .sidebar-collapsed .sidebar-logo-text { display: none; }
        .sidebar-collapsed .sidebar-user-info { display: none; }
        .sidebar-collapsed .sidebar-badge { display: none; }

        /* Overlay */
        .sidebar-overlay { @apply fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity lg:hidden; }

        /* Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.15); }

        /* ====== Topbar ====== */
        .topbar-search {
            @apply w-full pl-10 pr-4 py-2 bg-gray-100/80 border-0 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-brand-500/20 transition;
        }

        /* ====== Page animations ====== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.4s ease-out both; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .delay-3 { animation-delay: 0.15s; }
        .delay-4 { animation-delay: 0.2s; }

        /* ====== Stat card glow ====== */
        .stat-glow-blue { box-shadow: 0 8px 30px -8px rgba(37,99,235,0.25); }
        .stat-glow-emerald { box-shadow: 0 8px 30px -8px rgba(5,150,105,0.25); }
        .stat-glow-amber { box-shadow: 0 8px 30px -8px rgba(217,119,6,0.25); }
        .stat-glow-purple { box-shadow: 0 8px 30px -8px rgba(124,58,237,0.25); }

        /* ====== Table ====== */
        .data-table thead th {
            @apply bg-slate-50 text-slate-500 font-semibold text-[11px] uppercase tracking-wider;
        }
        .data-table tbody tr { @apply transition-colors duration-100; }
        .data-table tbody tr:hover { @apply bg-brand-50/40; }

        /* ====== Sidebar glow ring ====== */
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.4); }
            50% { box-shadow: 0 0 0 4px rgba(59,130,246,0); }
        }
        .online-pulse { animation: pulseGlow 2s ease-in-out infinite; }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen bg-[#f4f6fb] font-sans antialiased">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay hidden" onclick="toggleMobileSidebar()"></div>

    <!-- ====== SIDEBAR ====== -->
    <aside id="sidebar" class="fixed top-0 left-0 z-50 h-full bg-gradient-to-b from-[#0f172a] via-[#0f172a] to-[#020617] flex flex-col transition-all duration-300 w-[272px] -translate-x-full lg:translate-x-0 shadow-2xl shadow-slate-950/60 border-r border-white/[0.04]">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 h-[72px] border-b border-white/[0.06] flex-shrink-0">
            <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-brand-600/30 relative">
                <span class="text-white font-extrabold text-sm">ES</span>
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-[#0f172a] online-pulse"></div>
            </div>
            <div class="sidebar-logo-text">
                <span class="text-[15px] font-bold text-white tracking-tight">EASYSOLVE</span>
                <span class="block text-[9px] font-semibold text-brand-400/80 -mt-0.5 tracking-[0.15em] uppercase">Platform Admin</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-4 space-y-0.5">

            <div class="sidebar-section">Overview</div>

            <a href="{{ route('admin.dashboard') }}" data-tooltip="Dashboard" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-400' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-2.25-2.25v-2.25z"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <div class="sidebar-section">Manage</div>

            <a href="{{ route('admin.schools.index') }}" data-tooltip="Schools" class="sidebar-link {{ request()->routeIs('admin.schools.*') ? 'active' : 'text-slate-400' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
                </svg>
                <span class="sidebar-text">Schools</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-500/20 text-brand-300">{{ \App\Models\School::count() }}</span>
            </a>

            <a href="{{ route('admin.plans.index') }}" data-tooltip="Plans" class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : 'text-slate-400' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/>
                </svg>
                <span class="sidebar-text">Plans</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300">{{ \App\Models\Plan::count() }}</span>
            </a>

            <div class="sidebar-section">System</div>

            <a href="{{ route('admin.settings.index') }}" data-tooltip="Settings" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-slate-400' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="sidebar-text">Settings</span>
            </a>
        </nav>

        <!-- Sidebar User Card -->
        <div class="px-3 py-3 border-t border-white/[0.06] flex-shrink-0">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/[0.04] hover:bg-white/[0.07] transition-colors duration-200">
                <div class="relative flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-brand-500/20 ring-2 ring-brand-400/20">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-[#0f172a] online-pulse"></div>
                </div>
                <div class="sidebar-user-info min-w-0 flex-1">
                    <p class="text-[13px] font-semibold text-white truncate">{{ auth()->user()->full_name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-1.5 py-0.5 rounded bg-brand-500/15 text-brand-300">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            Admin
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="sidebar-user-info flex-shrink-0">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200" title="Sign out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Collapse toggle -->
        <div class="px-3 py-2 border-t border-white/[0.06] flex-shrink-0">
            <button onclick="toggleSidebar()" class="sidebar-link w-full text-slate-500 hover:text-slate-300 hover:bg-white/[0.04]" title="Toggle sidebar">
                <svg class="w-[18px] h-[18px] flex-shrink-0 transition-transform duration-300" id="collapse-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"/>
                </svg>
                <span class="sidebar-text">Collapse</span>
            </button>
        </div>
    </aside>

    <!-- ====== MAIN CONTENT ====== -->
    <div id="main-content" class="lg:ml-[272px] transition-all duration-300 min-h-screen flex flex-col">

        <!-- Topbar -->
        <header class="sticky top-0 z-30 bg-white/70 backdrop-blur-xl border-b border-gray-200/60">
            <div class="flex items-center justify-between h-[72px] px-4 sm:px-6 lg:px-8">
                <!-- Left -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleMobileSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-800 leading-tight">@yield('title', 'Dashboard')</h1>
                        <p class="text-[12px] text-slate-400 hidden sm:block">@yield('subtitle', 'Platform overview & management')</p>
                    </div>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-2">
                    <!-- Search (desktop) -->
                    <div class="hidden md:block relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <input type="text" placeholder="Search…" class="topbar-search w-56">
                    </div>

                    <div class="w-px h-8 bg-gray-200 hidden md:block mx-1"></div>

                    <!-- Admin badge -->
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-gradient-to-r from-brand-50 to-indigo-50 text-brand-700 border border-brand-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                        Admin
                    </span>

                    <!-- User avatar -->
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-brand-500/20 cursor-pointer">
                        {{ auth()->user()->initials }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 flex items-center gap-3 animate-fade-up">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-center gap-3 animate-fade-up">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200/60 bg-white/50 px-6 py-4">
            <div class="flex items-center justify-between text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} EASYSOLVE Platform</span>
                <span class="flex items-center gap-1.5">Built by <span class="font-semibold text-brand-600">WETech Technology</span></span>
            </div>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main-content');
            const icon = document.getElementById('collapse-icon');
            sidebar.classList.toggle('sidebar-collapsed');
            main.classList.toggle('lg:ml-[272px]');
            main.classList.toggle('lg:ml-[4.75rem]');
            icon.classList.toggle('rotate-180');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('sidebar-collapsed'));
        }
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.getElementById('sidebar').classList.add('sidebar-collapsed');
            document.getElementById('main-content').classList.remove('lg:ml-[272px]');
            document.getElementById('main-content').classList.add('lg:ml-[4.75rem]');
            document.getElementById('collapse-icon').classList.add('rotate-180');
        }
    </script>
    @stack('scripts')
</body>
</html>