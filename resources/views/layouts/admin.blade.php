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
            @apply bg-brand-50 text-brand-700;
        }
        .sidebar-link:hover .sidebar-icon {
            @apply scale-110;
        }
        .sidebar-link.active {
            @apply bg-gradient-to-r from-brand-50 to-brand-100/50 text-brand-700 font-semibold;
        }
        .sidebar-link.active::before {
            content: '';
            @apply absolute left-0 top-1/2 -translate-y-1/2 w-[3px] h-6 bg-brand-600 rounded-r-full;
        }
        .sidebar-link.active .sidebar-icon {
            @apply text-brand-600;
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
            @apply text-[10px] font-bold text-slate-500 uppercase tracking-[0.12em] px-3 mb-2 mt-6 first:mt-0 flex items-center gap-3 cursor-pointer select-none group/section;
        }
        .sidebar-section::after {
            content: '';
            @apply flex-1 h-px bg-gradient-to-r from-gray-200 to-transparent;
        }
        .sidebar-section:hover .section-chevron {
            @apply text-slate-500;
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
        .sidebar-collapsed .sidebar-search { display: none; }
        .sidebar-collapsed .sidebar-status { display: none; }
        .sidebar-collapsed .no-results-msg { display: none; }
        .sidebar-collapsed .sidebar-external { display: none; }

        /* Overlay */
        .sidebar-overlay { @apply fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity lg:hidden; }

        /* Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.08); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.15); }

        /* ====== Topbar ====== */
        .topbar-search {
            @apply w-full pl-10 pr-10 py-2 bg-gray-100/80 border-0 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-brand-500/20 transition;
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

        /* ====== Notification dropdown ====== */
        .notif-dropdown {
            @apply absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden;
            animation: fadeUp 0.2s ease-out both;
        }

        /* ====== Sidebar search highlight ====== */
        .search-highlight {
            @apply bg-brand-100 text-brand-700 rounded px-0.5;
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen bg-[#f4f6fb] font-sans antialiased">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay hidden" onclick="toggleMobileSidebar()"></div>

    <!-- ====== SIDEBAR ====== -->
    <aside id="sidebar" class="fixed top-0 left-0 z-50 h-full bg-white flex flex-col transition-all duration-300 w-[272px] -translate-x-full lg:translate-x-0 shadow-xl shadow-gray-200/60 border-r border-gray-200/60">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 h-[72px] border-b border-gray-100 flex-shrink-0">
            <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-brand-600/30 relative">
                <span class="text-white font-extrabold text-sm">ES</span>
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white online-pulse"></div>
            </div>
            <div class="sidebar-logo-text">
                <span class="text-[15px] font-bold text-slate-800 tracking-tight">EASYSOLVE</span>
                <span class="block text-[9px] font-semibold text-brand-500 -mt-0.5 tracking-[0.15em] uppercase">Platform Admin</span>
            </div>
        </div>

        <!-- Sidebar Search -->
        <div class="sidebar-search px-4 mt-4">
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" id="sidebar-search" placeholder="Search menu…" autocomplete="off"
                    class="w-full pl-9 pr-8 py-2 bg-gray-50 border border-gray-200 rounded-xl text-[12px] text-slate-600 placeholder-slate-400 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-500/20 outline-none transition-all duration-200">
                <button id="sidebar-search-clear" class="hidden absolute right-2 top-1/2 -translate-y-1/2 p-0.5 rounded-md text-slate-400 hover:text-slate-600 hover:bg-gray-100 transition" onclick="clearSidebarSearch()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-3 space-y-0.5" id="sidebar-nav">
            <p class="no-results-msg hidden text-center text-slate-500 text-[12px] py-8">No results found</p>

            {{-- Overview --}}
            <div class="sidebar-section" data-section="overview" onclick="toggleSection(this)">Overview<svg class="w-3 h-3 text-slate-600 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('admin.dashboard') }}" data-tooltip="Dashboard" data-nav-text="Dashboard" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-500' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-2.25-2.25v-2.25z"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            {{-- Management --}}
            <div class="sidebar-section" data-section="management" onclick="toggleSection(this)">Management<svg class="w-3 h-3 text-slate-600 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('admin.schools.index') }}" data-tooltip="Schools" data-nav-text="Schools" class="sidebar-link {{ request()->routeIs('admin.schools.*') ? 'active' : 'text-slate-500' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
                </svg>
                <span class="sidebar-text">Schools</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 text-brand-600">{{ \App\Models\School::count() }}</span>
            </a>

            <a href="{{ route('admin.schools.create', ['setup' => 1]) }}" data-tooltip="Add School" data-nav-text="Add School" class="sidebar-link {{ request()->routeIs('admin.schools.create') ? 'active' : 'text-slate-500' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span class="sidebar-text">Add School</span>
            </a>

            <a href="{{ route('admin.plans.index') }}" data-tooltip="Subscription Plans" data-nav-text="Plans" class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : 'text-slate-500' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5M3.75 3h16.5M3.75 15a1.5 1.5 0 010 3M20.25 15a1.5 1.5 0 010 3M3.75 9a1.5 1.5 0 010-3M20.25 9a1.5 1.5 0 010-3"/>
                </svg>
                <span class="sidebar-text">Plans</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600">{{ \App\Models\Plan::count() }}</span>
            </a>

            {{-- System --}}
            <div class="sidebar-section" data-section="system" onclick="toggleSection(this)">System<svg class="w-3 h-3 text-slate-600 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('admin.settings.index') }}" data-tooltip="Settings" data-nav-text="Settings" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-slate-500' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="sidebar-text">Settings</span>
            </a>

            {{-- External Links --}}
            <div class="sidebar-section" data-section="external" onclick="toggleSection(this)">External<svg class="w-3 h-3 text-slate-600 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <div class="sidebar-external">
                <a href="{{ route('home') }}" data-tooltip="View Website" data-nav-text="View Website" target="_blank" class="sidebar-link text-slate-500">
                    <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                    </svg>
                    <span class="sidebar-text">View Website</span>
                    <svg class="w-3 h-3 ml-auto text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                </a>

                <a href="{{ route('help') }}" data-tooltip="Help & Support" data-nav-text="Help & Support" target="_blank" class="sidebar-link text-slate-500">
                    <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                    <span class="sidebar-text">Help & Support</span>
                </a>
            </div>
        </nav>

        <!-- Platform Status Widget -->
        <div class="sidebar-status px-3 pb-3 flex-shrink-0">
            @php
                $totalSchools = \App\Models\School::count();
                $activeSchools = \App\Models\School::where('subscription_status', 'active')->count();
                $trialSchools = \App\Models\School::where('subscription_status', 'trial')->count();
            @endphp
            <div class="rounded-xl bg-gray-50 border border-gray-100 p-3.5">
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Platform Health</span>
                    <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Operational
                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-400">Active</span>
                        <span class="font-bold text-emerald-400">{{ $activeSchools }} / {{ $totalSchools }}</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-500" style="width: {{ $totalSchools > 0 ? ($activeSchools / $totalSchools) * 100 : 0 }}%"></div>
                    </div>
                    @if($trialSchools > 0)
                    <div class="flex items-center justify-between text-[11px] pt-1">
                        <span class="text-slate-400">On Trial</span>
                        <span class="font-bold text-amber-400">{{ $trialSchools }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar User Card -->
        <div class="px-3 py-3 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                <div class="relative flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-brand-500/20 ring-2 ring-brand-400/20">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white online-pulse"></div>
                </div>
                <div class="sidebar-user-info min-w-0 flex-1">
                    <p class="text-[13px] font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-1.5 py-0.5 rounded bg-brand-50 text-brand-600">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            Super Admin
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="sidebar-user-info flex-shrink-0">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200" title="Sign out">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Collapse toggle -->
        <div class="px-3 py-2 border-t border-gray-100 flex-shrink-0">
            <button onclick="toggleSidebar()" class="sidebar-link w-full text-slate-400 hover:text-slate-600 hover:bg-gray-50" title="Toggle sidebar">
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
                        <input type="text" id="topbar-search" placeholder="Search pages…" autocomplete="off" class="topbar-search w-56">
                    </div>

                    <div class="w-px h-8 bg-gray-200 hidden md:block mx-1"></div>

                    <!-- Notification Bell -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="relative p-2.5 rounded-xl text-slate-500 hover:text-brand-600 hover:bg-brand-50 transition-all duration-200" title="Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                            @php $trialCount = \App\Models\School::where('subscription_status', 'trial')->count(); @endphp
                            @if($trialCount > 0)
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white"></span>
                            @endif
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notif-dropdown" class="notif-dropdown hidden">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="text-sm font-bold text-slate-800">Notifications</h3>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 text-brand-600">{{ $trialCount }} new</span>
                            </div>
                            <div class="max-h-80 overflow-y-auto sidebar-scroll">
                                @php $trialSchools = \App\Models\School::where('subscription_status', 'trial')->latest()->take(5)->get(); @endphp
                                @if($trialSchools->count() > 0)
                                    @foreach($trialSchools as $school)
                                    <a href="{{ route('admin.schools.show', $school) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-[13px] font-semibold text-slate-700 truncate">{{ $school->name }}</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">On trial · {{ $school->trialDaysLeft() }} days left</p>
                                        </div>
                                    </a>
                                    @endforeach
                                @else
                                    <div class="px-4 py-10 text-center">
                                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                        </div>
                                        <p class="text-sm text-slate-400">All caught up!</p>
                                        <p class="text-xs text-slate-300 mt-1">No new notifications</p>
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50/50">
                                <a href="{{ route('admin.dashboard') }}" class="text-[12px] font-semibold text-brand-600 hover:text-brand-700 transition">View dashboard</a>
                            </div>
                        </div>
                    </div>

                    <!-- Admin badge -->
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-gradient-to-r from-brand-50 to-indigo-50 text-brand-700 border border-brand-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                        Admin
                    </span>

                    <!-- User avatar -->
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-brand-500/20 cursor-pointer">
                        {{ auth()->user()->initials }}
                    </div>

                    <!-- Sign out -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Sign out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span class="hidden sm:inline text-xs font-semibold">Sign out</span>
                        </button>
                    </form>
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
        // ===== Sidebar Collapse Toggle =====
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

        // Restore collapsed state
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.getElementById('sidebar').classList.add('sidebar-collapsed');
            document.getElementById('main-content').classList.remove('lg:ml-[272px]');
            document.getElementById('main-content').classList.add('lg:ml-[4.75rem]');
            document.getElementById('collapse-icon').classList.add('rotate-180');
        }

        // ===== Collapsible Sections =====
        function toggleSection(sectionEl) {
            const chevron = sectionEl.querySelector('.section-chevron');
            let next = sectionEl.nextElementSibling;
            const isCollapsed = sectionEl.dataset.collapsed === 'true';

            if (isCollapsed) {
                while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg') && !next.classList.contains('sidebar-status')) {
                    next.style.display = '';
                    next = next.nextElementSibling;
                }
                sectionEl.dataset.collapsed = 'false';
                chevron.style.transform = '';
            } else {
                while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg') && !next.classList.contains('sidebar-status')) {
                    next.style.display = 'none';
                    next = next.nextElementSibling;
                }
                sectionEl.dataset.collapsed = 'true';
                chevron.style.transform = 'rotate(-90deg)';
            }
        }

        // ===== Sidebar Search =====
        function performSidebarSearch(query) {
            const nav = document.getElementById('sidebar-nav');
            const links = nav.querySelectorAll('.sidebar-link');
            const sections = nav.querySelectorAll('.sidebar-section');
            const noResults = nav.querySelector('.no-results-msg');
            const clearBtn = document.getElementById('sidebar-search-clear');

            query = query.trim().toLowerCase();
            clearBtn.classList.toggle('hidden', query === '');

            if (query === '') {
                links.forEach(l => l.style.display = '');
                sections.forEach(s => {
                    s.style.display = '';
                    if (s.dataset.collapsed === 'true') {
                        let next = s.nextElementSibling;
                        while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg') && !next.classList.contains('sidebar-status')) {
                            next.style.display = 'none';
                            next = next.nextElementSibling;
                        }
                    } else {
                        let next = s.nextElementSibling;
                        while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg') && !next.classList.contains('sidebar-status')) {
                            next.style.display = '';
                            next = next.nextElementSibling;
                        }
                    }
                });
                noResults.classList.add('hidden');
                return;
            }

            let matchCount = 0;
            const sectionHasMatch = {};

            links.forEach(link => {
                const text = (link.getAttribute('data-nav-text') || link.textContent).toLowerCase();
                const matches = text.includes(query);
                link.style.display = matches ? '' : 'none';
                if (matches) matchCount++;

                let prev = link.previousElementSibling;
                while (prev) {
                    if (prev.classList.contains('sidebar-section')) {
                        if (matches) sectionHasMatch[prev.getAttribute('data-section')] = true;
                        break;
                    }
                    prev = prev.previousElementSibling;
                }
            });

            sections.forEach(s => {
                const sectionName = s.getAttribute('data-section');
                if (sectionHasMatch[sectionName]) {
                    s.style.display = '';
                    s.dataset.collapsed = 'false';
                    const chevron = s.querySelector('.section-chevron');
                    if (chevron) chevron.style.transform = '';
                } else {
                    s.style.display = 'none';
                }
            });

            noResults.classList.toggle('hidden', matchCount > 0);
        }

        function clearSidebarSearch() {
            const input = document.getElementById('sidebar-search');
            input.value = '';
            performSidebarSearch('');
            input.focus();
        }

        document.getElementById('sidebar-search').addEventListener('input', function(e) {
            performSidebarSearch(e.target.value);
        });

        // Topbar search also triggers sidebar search
        const topbarSearch = document.getElementById('topbar-search');
        if (topbarSearch) {
            topbarSearch.addEventListener('input', function(e) {
                const sidebarInput = document.getElementById('sidebar-search');
                sidebarInput.value = e.target.value;
                performSidebarSearch(e.target.value);
            });
            topbarSearch.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const nav = document.getElementById('sidebar-nav');
                    const visibleLinks = [...nav.querySelectorAll('.sidebar-link')].filter(l => l.style.display !== 'none');
                    if (visibleLinks.length > 0) {
                        visibleLinks[0].click();
                    }
                }
            });
        }

        document.getElementById('sidebar-search').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const nav = document.getElementById('sidebar-nav');
                const visibleLinks = [...nav.querySelectorAll('.sidebar-link')].filter(l => l.style.display !== 'none');
                if (visibleLinks.length > 0) {
                    visibleLinks[0].click();
                }
            }
            if (e.key === 'Escape') {
                clearSidebarSearch();
            }
        });

        // ===== Notification Dropdown =====
        function toggleNotifications() {
            const dropdown = document.getElementById('notif-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notif-dropdown');
            const bell = e.target.closest('[onclick="toggleNotifications()"]');
            if (!dropdown.contains(e.target) && !bell) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
