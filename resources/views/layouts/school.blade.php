<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — {{ auth()->user()->school?->name ?? 'EASYSOLVE' }}</title>
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
        /* ====== Sidebar (Clean White Professional) ====== */
        .sidebar-link {
            @apply flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-200 relative group/link text-slate-600;
        }
        .sidebar-link .sidebar-icon {
            @apply transition-all duration-200 text-slate-400;
        }
        .sidebar-link:hover {
            @apply bg-gray-50 text-slate-900;
        }
        .sidebar-link:hover .sidebar-icon {
            @apply text-slate-600;
        }
        .sidebar-link.active {
            @apply text-amber-700 font-semibold;
            background: #FFFBEB;
        }
        .sidebar-link.active .sidebar-icon {
            @apply text-amber-600;
        }

        /* Tooltip for collapsed sidebar */
        .sidebar-collapsed .sidebar-link {
            @apply relative;
        }
        .sidebar-collapsed .sidebar-link::after {
            content: attr(data-tooltip);
            @apply absolute left-full ml-3 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-lg whitespace-nowrap opacity-0 pointer-events-none transition-opacity duration-200 shadow-xl z-[999];
            border: 1px solid rgba(0,0,0,0.06);
        }
        .sidebar-collapsed .sidebar-link:hover::after {
            @apply opacity-100;
        }

        .sidebar-section {
            @apply text-[10px] font-bold text-gray-400 uppercase tracking-[0.12em] px-3 mb-2 mt-6 first:mt-0 flex items-center cursor-pointer select-none group/section;
        }
        .sidebar-section:hover {
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
        .sidebar-collapsed .sidebar-term-banner { display: none; }
        .sidebar-collapsed .no-results-msg { display: none; }

        /* Overlay */
        .sidebar-overlay { @apply fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity lg:hidden; }

        /* Scrollbar (light) */
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

        /* ====== Top nav for students/parents ====== */
        .nav-link {
            @apply text-sm font-medium text-slate-500 hover:text-brand-600 transition relative py-1;
        }
        .nav-link.active {
            @apply text-brand-600 font-semibold;
        }
        .nav-link.active::after {
            content: '';
            @apply absolute -bottom-2 left-0 right-0 h-0.5 bg-brand-500 rounded-full;
        }

        /* ====== Online pulse ====== */
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.4); }
            50% { box-shadow: 0 0 0 4px rgba(59,130,246,0); }
        }
        .online-pulse { animation: pulseGlow 2s ease-in-out infinite; }

        /* ====== Sidebar search highlight ====== */
        .search-highlight {
            @apply bg-brand-100 text-brand-700 rounded px-0.5;
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen bg-[#f4f6fb] font-sans antialiased">

    @php $isSchoolManager = auth()->user()->canManageSchool(); @endphp

    @if($isSchoolManager)
    <!-- ========== SCHOOL MANAGER LAYOUT (New Sidebar) ========== -->
    <div id="sidebar-overlay" class="sidebar-overlay hidden" onclick="toggleMobileSidebar()"></div>

    <aside id="sidebar" class="fixed top-0 left-0 z-50 h-full flex flex-col transition-all duration-300 w-[272px] -translate-x-full lg:translate-x-0 shadow-xl shadow-black/5 border-r border-gray-200 bg-white">

        <!-- Logo & School Branding -->
                <div class="flex items-center gap-3 px-5 h-[68px] border-b border-gray-100 flex-shrink-0">
            <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-indigo-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-brand-600/40 relative">
                <span class="text-white font-extrabold text-sm">ES</span>
            </div>
            <div class="sidebar-logo-text min-w-0">
                <span class="text-[15px] font-bold text-slate-800 tracking-tight block truncate">{{ auth()->user()->school?->short_name ?? 'EASYSOLVE' }}</span>
                @if(auth()->user()->isOwner())
                    <span class="inline-flex items-center gap-1 text-[9px] font-bold text-amber-600 tracking-[0.12em] uppercase">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Owner Portal
                    </span>
                @elseif(auth()->user()->isAdmin())
                    <span class="inline-flex items-center gap-1 text-[9px] font-bold text-brand-600 tracking-[0.12em] uppercase">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/></svg>
                        Admin Portal
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-[9px] font-bold text-emerald-600 tracking-[0.12em] uppercase">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-3.11 1.333L10 12l6.394-2.74a1 1 0 000-1.84l-7-3z"/></svg>
                        Teacher Portal
                    </span>
                @endif
            </div>
            <!-- Mobile close button -->
            <button onclick="toggleMobileSidebar()" class="lg:hidden ml-auto w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-slate-700 hover:bg-gray-100 transition" aria-label="Close sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Current Term Banner -->
        @php $currentTerm = auth()->user()->school?->currentTerm; @endphp
        @if($currentTerm)
        <div class="sidebar-term-banner mx-4 mt-4 px-3 py-2.5 rounded-xl bg-indigo-50 border border-indigo-100">
            <div class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <div class="min-w-0">
                    <p class="text-[9px] font-bold text-indigo-600 uppercase tracking-wider">Active Term</p>
                    <p class="text-[11px] font-medium text-slate-600 truncate">{{ $currentTerm->name }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Sidebar Search -->
        <div class="sidebar-search px-4 mt-4">
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" id="sidebar-search" placeholder="Search menu…" autocomplete="off"
                    class="w-full pl-9 pr-8 py-2 bg-gray-100 border border-gray-200 rounded-xl text-[12px] text-slate-700 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500/20 outline-none transition-all duration-200">
                <button id="sidebar-search-clear" class="hidden absolute right-2 top-1/2 -translate-y-1/2 p-0.5 rounded-md text-slate-400 hover:text-slate-600 hover:bg-gray-200 transition" onclick="clearSidebarSearch()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-3 space-y-0.5" id="sidebar-nav">
            <p class="no-results-msg hidden text-center text-slate-400 text-[12px] py-8">No results found</p>

            {{-- Overview --}}
            <div class="sidebar-section" data-section="overview" onclick="toggleSection(this)">Overview<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.dashboard') }}" data-tooltip="Dashboard" data-nav-text="Dashboard" class="sidebar-link {{ request()->routeIs('school.dashboard') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-2.25-2.25v-2.25z"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            {{-- People (Owner & Admin only) --}}
            @if(auth()->user()->isOwner() || auth()->user()->isAdmin())
            <div class="sidebar-section" data-section="people" onclick="toggleSection(this)">People<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.users.index') }}" data-tooltip="Users" data-nav-text="Users" class="sidebar-link {{ request()->routeIs('school.users.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                <span class="sidebar-text">Users</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-violet-50 text-violet-600">{{ auth()->user()->school?->users()->count() ?? 0 }}</span>
            </a>
            @endif

            {{-- Academics --}}
            <div class="sidebar-section" data-section="academics" onclick="toggleSection(this)">Academics<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            @if(auth()->user()->isOwner() || auth()->user()->isAdmin())
            <a href="{{ route('school.classes.index') }}" data-tooltip="Classes" data-nav-text="Classes" class="sidebar-link {{ request()->routeIs('school.classes.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
                </svg>
                <span class="sidebar-text">Classes</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600">{{ auth()->user()->school?->classes()->count() ?? 0 }}</span>
            </a>

            <a href="{{ route('school.subjects.index') }}" data-tooltip="Subjects" data-nav-text="Subjects" class="sidebar-link {{ request()->routeIs('school.subjects.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                <span class="sidebar-text">Subjects</span>
            </a>

            <a href="{{ route('school.sessions.index') }}" data-tooltip="Sessions & Terms" data-nav-text="Sessions & Terms" class="sidebar-link {{ request()->routeIs('school.sessions.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <span class="sidebar-text">Sessions & Terms</span>
            </a>
            @endif

            <a href="{{ route('school.attendance.index') }}" data-tooltip="Attendance" data-nav-text="Attendance" class="sidebar-link {{ request()->routeIs('school.attendance.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="sidebar-text">Attendance</span>
            </a>

            <a href="{{ route('school.staff-attendance.index') }}" data-tooltip="Staff Attendance" data-nav-text="Staff Attendance" class="sidebar-link {{ request()->routeIs('school.staff-attendance.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="sidebar-text">Staff Attendance</span>
            </a>

            <a href="{{ route('school.timetable.index') }}" data-tooltip="Timetable" data-nav-text="Timetable" class="sidebar-link {{ request()->routeIs('school.timetable.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0V11.25c0-1.243 1.007-2.25 2.25-2.25h13.5c1.243 0 2.25 1.007 2.25 2.25v7.5"/>
                </svg>
                <span class="sidebar-text">Timetable</span>
            </a>

            <a href="{{ route('school.grades.index') }}" data-tooltip="Grades" data-nav-text="Grades" class="sidebar-link {{ request()->routeIs('school.grades.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
                <span class="sidebar-text">Grades</span>
            </a>

            <a href="{{ route('school.exams.index') }}" data-tooltip="Exams" data-nav-text="Exams" class="sidebar-link {{ request()->routeIs('school.exams.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="sidebar-text">Exams</span>
            </a>

            <a href="{{ route('school.homework.index') }}" data-tooltip="Homework" data-nav-text="Homework" class="sidebar-link {{ request()->routeIs('school.homework.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                </svg>
                <span class="sidebar-text">Homework</span>
            </a>

            <a href="{{ route('school.library.index') }}" data-tooltip="Library" data-nav-text="Library" class="sidebar-link {{ request()->routeIs('school.library.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                <span class="sidebar-text">Library</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600">{{ auth()->user()->school?->libraryBooks()->count() ?? 0 }}</span>
            </a>

            {{-- Communication --}}
            <div class="sidebar-section" data-section="communication" onclick="toggleSection(this)">Communication<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.announcements.index') }}" data-tooltip="Announcements" data-nav-text="Announcements" class="sidebar-link {{ request()->routeIs('school.announcements.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z"/>
                </svg>
                <span class="sidebar-text">Announcements</span>
            </a>

            <a href="{{ route('school.events.index') }}" data-tooltip="Events & Calendar" data-nav-text="Events Calendar" class="sidebar-link {{ request()->routeIs('school.events.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <span class="sidebar-text">Events & Calendar</span>
            </a>

            <a href="{{ route('school.messages.index') }}" data-tooltip="Messages" data-nav-text="Messages" class="sidebar-link {{ request()->routeIs('school.messages.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.294 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v.51z"/>
                </svg>
                <span class="sidebar-text">Messages</span>
            </a>

            {{-- Finance (Owner & Admin only) --}}
            @if(auth()->user()->isOwner() || auth()->user()->isAdmin())
            <div class="sidebar-section" data-section="finance" onclick="toggleSection(this)">Finance<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.fees.index') }}" data-tooltip="Fees" data-nav-text="Fee Structure" class="sidebar-link {{ request()->routeIs('school.fees.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                </svg>
                <span class="sidebar-text">Fee Structure</span>
            </a>

            <a href="{{ route('school.payments.index') }}" data-tooltip="Payments" data-nav-text="Payments" class="sidebar-link {{ request()->routeIs('school.payments.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                </svg>
                <span class="sidebar-text">Payments</span>
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-600">{{ auth()->user()->school?->payments()->whereMonth('created_at', now()->month)->count() ?? 0 }}</span>
            </a>
            @endif

            {{-- Insights (Owner & Admin only) --}}
            @if(auth()->user()->isOwner() || auth()->user()->isAdmin())
            <div class="sidebar-section" data-section="insights" onclick="toggleSection(this)">Insights<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.reports.index') }}" data-tooltip="Reports" data-nav-text="Reports" class="sidebar-link {{ request()->routeIs('school.reports.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                </svg>
                <span class="sidebar-text">Reports</span>
            </a>
            @endif

            {{-- Account / School Settings --}}
            @if(auth()->user()->isOwner())
            <div class="sidebar-section" data-section="school" onclick="toggleSection(this)">School<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.settings.index') }}" data-tooltip="School Settings" data-nav-text="School Settings" class="sidebar-link {{ request()->routeIs('school.settings.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
                <span class="sidebar-text">School Settings</span>
                <span class="sidebar-badge ml-auto text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-amber-50 text-amber-600">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </span>
            </a>

            <a href="{{ route('school.billing.index') }}" data-tooltip="Billing & Subscription" data-nav-text="Billing" class="sidebar-link {{ request()->routeIs('school.billing.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v8.25A2.25 2.25 0 004.5 15z"/>
                </svg>
                <span class="sidebar-text">Billing</span>
                @php $pendingCount = auth()->user()->school?->paymentRequests()->where('status', 'pending')->count() ?? 0; @endphp
                @if($pendingCount > 0)
                <span class="sidebar-badge ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-600">{{ $pendingCount }}</span>
                @endif
            </a>
            @else
            <div class="sidebar-section" data-section="account" onclick="toggleSection(this)">Account<svg class="w-3 h-3 text-gray-400 transition-transform duration-200 section-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg></div>

            <a href="{{ route('school.settings.index') }}" data-tooltip="Settings" data-nav-text="Settings" class="sidebar-link {{ request()->routeIs('school.settings.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="sidebar-text">Settings</span>
            </a>

            @if(auth()->user()->school?->terms_and_conditions)
            <a href="{{ route('school.terms.show') }}" data-tooltip="Terms & Conditions" data-nav-text="Terms & Conditions" class="sidebar-link {{ request()->routeIs('school.terms.*') ? 'active' : 'text-slate-600' }}">
                <svg class="sidebar-icon w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
                <span class="sidebar-text">Terms & Conditions</span>
            </a>
            @endif
            @endif
        </nav>

        <!-- User Card -->
        <div class="px-3 py-3 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-xl {{ auth()->user()->isOwner() ? 'bg-gradient-to-br from-amber-400 to-orange-500 shadow-amber-500/20' : 'bg-gradient-to-br from-brand-400 to-indigo-500 shadow-brand-500/20' }} flex items-center justify-center text-white font-bold text-xs shadow-lg ring-2 {{ auth()->user()->isOwner() ? 'ring-amber-400/20' : 'ring-brand-400/20' }}">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white"></div>
                </div>
                <div class="sidebar-user-info min-w-0 flex-1">
                    <p class="text-[13px] font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-1.5 py-0.5 rounded {{ auth()->user()->isOwner() ? 'bg-amber-50 text-amber-600' : (auth()->user()->isAdmin() ? 'bg-brand-50 text-brand-600' : 'bg-emerald-50 text-emerald-600') }}">
                            @if(auth()->user()->isOwner())
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Owner
                            @elseif(auth()->user()->isAdmin())
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/></svg>
                            Admin
                            @else
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-3.11 1.333L10 12l6.394-2.74a1 1 0 000-1.84l-7-3z"/></svg>
                            Teacher
                            @endif
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="sidebar-user-info flex-shrink-0">
                    @csrf
                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Sign out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Collapse toggle -->
        <div class="px-3 py-2 border-t border-gray-100 flex-shrink-0">
            <button onclick="toggleSidebar()" class="sidebar-link w-full text-slate-400 hover:text-slate-700 hover:bg-gray-50" title="Toggle sidebar">
                <svg class="w-[18px] h-[18px] flex-shrink-0 transition-transform duration-300" id="collapse-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"/>
                </svg>
                <span class="sidebar-text">Collapse</span>
            </button>
        </div>
    </aside>

    <div id="main-content" class="lg:ml-[272px] transition-all duration-300 min-h-screen flex flex-col">
        <header class="sticky top-0 z-30 bg-white/70 backdrop-blur-xl border-b border-gray-200/60">
            <div class="flex items-center justify-between h-[72px] px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button onclick="toggleMobileSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-800 leading-tight">@yield('title', 'Dashboard')</h1>
                        <p class="text-[12px] text-slate-400 hidden sm:block">@yield('subtitle', auth()->user()->school?->name ?? '')</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="hidden md:flex items-center gap-2">
                        <div class="relative group">
                            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                            <input type="text" id="topbar-search" placeholder="Search pages…" autocomplete="off"
                                class="w-64 pl-10 pr-16 py-2 bg-gray-50 border border-gray-200 rounded-xl text-[13px] text-slate-700 placeholder-slate-400 focus:bg-white focus:border-brand-400 focus:ring-2 focus:ring-brand-500/15 focus:shadow-sm outline-none transition-all duration-200">
                            <kbd class="absolute right-2.5 top-1/2 -translate-y-1/2 hidden lg:flex items-center gap-0.5 px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 bg-white border border-gray-200 rounded-md group-focus-within:opacity-0 transition-opacity">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.5-7.5h15"/></svg>
                                K
                            </kbd>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-gray-200 hidden md:block mx-1"></div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full {{ auth()->user()->isOwner() ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border border-amber-100' : (auth()->user()->isAdmin() ? 'bg-gradient-to-r from-brand-50 to-indigo-50 text-brand-700 border border-brand-100' : 'bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 border border-emerald-100') }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isOwner() ? 'bg-amber-500' : (auth()->user()->isAdmin() ? 'bg-brand-500' : 'bg-emerald-500') }} animate-pulse"></span>
                        {{ auth()->user()->isOwner() ? 'Owner' : (auth()->user()->isAdmin() ? 'Admin' : 'Teacher') }}
                    </span>
                    <div class="w-9 h-9 rounded-full {{ auth()->user()->isOwner() ? 'bg-gradient-to-br from-amber-400 to-orange-500 shadow-amber-500/20' : (auth()->user()->isAdmin() ? 'bg-gradient-to-br from-brand-500 to-indigo-600 shadow-brand-500/20' : 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-emerald-500/20') }} flex items-center justify-center text-white font-bold text-xs shadow-lg">
                        {{ auth()->user()->initials }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2 rounded-xl hover:bg-red-50" title="Sign out">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 flex items-center gap-3 animate-fade-up">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-gray-200/60 bg-white/50 px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-400 text-center sm:text-left">
                <span>&copy; {{ date('Y') }} {{ auth()->user()->school?->name ?? 'EASYSOLVE' }}</span>
                <span class="flex items-center gap-1.5 justify-center">Built by <span class="font-semibold text-brand-600">WETech Technology</span></span>
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
            const sectionName = sectionEl.getAttribute('data-section');
            const chevron = sectionEl.querySelector('.section-chevron');
            const nav = document.getElementById('sidebar-nav');
            let next = sectionEl.nextElementSibling;
            const isCollapsed = sectionEl.dataset.collapsed === 'true';

            if (isCollapsed) {
                // Expand: show items until next section
                while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg')) {
                    next.style.display = '';
                    next = next.nextElementSibling;
                }
                sectionEl.dataset.collapsed = 'false';
                chevron.style.transform = '';
            } else {
                // Collapse: hide items until next section
                while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg')) {
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
                // Reset: show everything, respect collapsed sections
                links.forEach(l => l.style.display = '');
                sections.forEach(s => {
                    s.style.display = '';
                    if (s.dataset.collapsed === 'true') {
                        // Keep collapsed sections collapsed
                        let next = s.nextElementSibling;
                        while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg')) {
                            next.style.display = 'none';
                            next = next.nextElementSibling;
                        }
                    } else {
                        let next = s.nextElementSibling;
                        while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg')) {
                            next.style.display = '';
                            next = next.nextElementSibling;
                        }
                    }
                });
                noResults.classList.add('hidden');
                return;
            }

            // Expand all sections during search
            let matchCount = 0;
            const sectionHasMatch = {};

            links.forEach(link => {
                const text = (link.getAttribute('data-nav-text') || link.textContent).toLowerCase();
                const matches = text.includes(query);
                link.style.display = matches ? '' : 'none';
                if (matches) matchCount++;

                // Track which sections have matches
                let prev = link.previousElementSibling;
                while (prev) {
                    if (prev.classList.contains('sidebar-section')) {
                        if (matches) sectionHasMatch[prev.getAttribute('data-section')] = true;
                        break;
                    }
                    prev = prev.previousElementSibling;
                }
            });

            // Show/hide sections based on whether they have matching items
            sections.forEach(s => {
                const sectionName = s.getAttribute('data-section');
                if (sectionHasMatch[sectionName]) {
                    s.style.display = '';
                    // Expand section during search
                    s.dataset.collapsed = 'false';
                    const chevron = s.querySelector('.section-chevron');
                    if (chevron) chevron.style.transform = '';
                    let next = s.nextElementSibling;
                    while (next && !next.classList.contains('sidebar-section') && !next.classList.contains('no-results-msg')) {
                        if (next.style.display !== 'none') {
                            // Already set by link filtering
                        }
                        next = next.nextElementSibling;
                    }
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

        // Sidebar search input listener
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
                    // Navigate to first visible matching link
                    const nav = document.getElementById('sidebar-nav');
                    const visibleLinks = [...nav.querySelectorAll('.sidebar-link')].filter(l => l.style.display !== 'none');
                    if (visibleLinks.length > 0) {
                        visibleLinks[0].click();
                    }
                }
            });
        }

        // Sidebar search Enter key navigates to first match
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

        // ===== Keyboard shortcut: Cmd/Ctrl+K to focus search =====
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                const topbarSearch = document.getElementById('topbar-search');
                const sidebarSearch = document.getElementById('sidebar-search');
                const target = window.innerWidth >= 768 ? topbarSearch : sidebarSearch;
                if (target) {
                    target.focus();
                    target.select();
                }
            }
            if (e.key === 'Escape') {
                const topbarSearch = document.getElementById('topbar-search');
                if (topbarSearch && document.activeElement === topbarSearch) {
                    topbarSearch.value = '';
                    topbarSearch.blur();
                }
            }
        });
    </script>

    @else
    <!-- ========== STUDENT / PARENT LAYOUT (Top Nav + Hamburger) ========== -->

    <!-- Mobile menu overlay -->
    <div id="mobile-menu-overlay" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-40 md:hidden transition-opacity duration-300" onclick="toggleMobileMenu()"></div>

    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo + Desktop Nav -->
                <div class="flex items-center gap-4 md:gap-8 min-w-0">
                    <a href="{{ route('school.dashboard') }}" class="flex items-center gap-2.5 flex-shrink-0">
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/20 flex-shrink-0">
                            <span class="text-white font-extrabold text-sm">ES</span>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-slate-800 truncate">{{ auth()->user()->school?->short_name ?? 'EASYSOLVE' }}</span>
                    </a>
                    <nav class="hidden md:flex items-center gap-6">
                        @if(auth()->user()->isStudent())
                            <a href="{{ route('school.dashboard') }}" class="nav-link {{ request()->routeIs('school.dashboard') ? 'active' : '' }}">Home</a>
                            <a href="{{ route('school.attendance.index') }}" class="nav-link {{ request()->routeIs('school.attendance.*') ? 'active' : '' }}">Attendance</a>
                            <a href="{{ route('school.grades.index') }}" class="nav-link {{ request()->routeIs('school.grades.*') ? 'active' : '' }}">Grades</a>
                            <a href="{{ route('school.homework.index') }}" class="nav-link {{ request()->routeIs('school.homework.*') ? 'active' : '' }}">Homework</a>
                            <a href="{{ route('school.exams.index') }}" class="nav-link {{ request()->routeIs('school.exams.*') ? 'active' : '' }}">Exams</a>
                            <a href="{{ route('school.events.index') }}" class="nav-link {{ request()->routeIs('school.events.*') ? 'active' : '' }}">Events</a>
                            <a href="{{ route('school.payments.index') }}" class="nav-link {{ request()->routeIs('school.payments.*') ? 'active' : '' }}">Payments</a>
                            <a href="{{ route('school.announcements.index') }}" class="nav-link {{ request()->routeIs('school.announcements.*') ? 'active' : '' }}">Announcements</a>
                            <a href="{{ route('school.messages.index') }}" class="nav-link {{ request()->routeIs('school.messages.*') ? 'active' : '' }}">Messages</a>
                        @elseif(auth()->user()->isParent())
                            <a href="{{ route('school.dashboard') }}" class="nav-link {{ request()->routeIs('school.dashboard') ? 'active' : '' }}">Home</a>
                            <a href="{{ route('school.attendance.index') }}" class="nav-link {{ request()->routeIs('school.attendance.*') ? 'active' : '' }}">Attendance</a>
                            <a href="{{ route('school.grades.index') }}" class="nav-link {{ request()->routeIs('school.grades.*') ? 'active' : '' }}">Grades</a>
                            <a href="{{ route('school.homework.index') }}" class="nav-link {{ request()->routeIs('school.homework.*') ? 'active' : '' }}">Homework</a>
                            <a href="{{ route('school.exams.index') }}" class="nav-link {{ request()->routeIs('school.exams.*') ? 'active' : '' }}">Exams</a>
                            <a href="{{ route('school.events.index') }}" class="nav-link {{ request()->routeIs('school.events.*') ? 'active' : '' }}">Events</a>
                            <a href="{{ route('school.fees.index') }}" class="nav-link {{ request()->routeIs('school.fees.*') ? 'active' : '' }}">Fees</a>
                            <a href="{{ route('school.payments.index') }}" class="nav-link {{ request()->routeIs('school.payments.*') ? 'active' : '' }}">Payments</a>
                            <a href="{{ route('school.reports.report-card') }}" class="nav-link {{ request()->routeIs('school.reports.*') ? 'active' : '' }}">Report Card</a>
                            <a href="{{ route('school.announcements.index') }}" class="nav-link {{ request()->routeIs('school.announcements.*') ? 'active' : '' }}">Announcements</a>
                            <a href="{{ route('school.messages.index') }}" class="nav-link {{ request()->routeIs('school.messages.*') ? 'active' : '' }}">Messages</a>
                        @endif
                    </nav>
                </div>

                <!-- Right: Controls -->
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-gradient-to-r from-brand-50 to-indigo-50 text-brand-700 border border-brand-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                    <div class="relative">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center text-white font-bold text-[10px] sm:text-xs shadow-lg shadow-brand-500/20">
                            {{ auth()->user()->initials }}
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-white"></div>
                    </div>

                    {{-- Hamburger button (mobile only) --}}
                    <button type="button" onclick="toggleMobileMenu()" class="md:hidden relative w-10 h-10 flex items-center justify-center rounded-xl text-slate-600 hover:bg-gray-100 transition" aria-label="Toggle menu" id="hamburger-btn">
                        <svg class="w-5 h-5 hamburger-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        <svg class="w-5 h-5 close-icon hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1.5 rounded-lg hover:bg-red-50" title="Sign out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Mobile slide-down menu --}}
        <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0 transition-all duration-300 ease-in-out bg-white border-t border-gray-100">
            {{-- User Info Header --}}
            <div class="px-4 py-4 border-b border-gray-50 flex items-center gap-3">
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-lg">
                        {{ auth()->user()->initials }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-white"></div>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 text-brand-600">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            {{-- Nav Links --}}
            <nav class="px-3 py-3 space-y-0.5">
                @php
                    $mobileNavItems = [
                        ['route' => 'school.dashboard', 'active' => 'school.dashboard', 'label' => 'Home', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.5a.75.75 0 01.75.75h4.5a.75.75 0 01.75-.75V15a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v4.5a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75V9.75M8.25 3h7.5'],
                    ];
                    if (auth()->user()->isStudent()) {
                        $mobileNavItems = array_merge($mobileNavItems, [
                            ['route' => 'school.attendance.index', 'active' => 'school.attendance.*', 'label' => 'Attendance', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['route' => 'school.grades.index', 'active' => 'school.grades.*', 'label' => 'Grades', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
                            ['route' => 'school.homework.index', 'active' => 'school.homework.*', 'label' => 'Homework', 'icon' => 'M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184'],
                            ['route' => 'school.exams.index', 'active' => 'school.exams.*', 'label' => 'Exams', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['route' => 'school.events.index', 'active' => 'school.events.*', 'label' => 'Events', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                            ['route' => 'school.payments.index', 'active' => 'school.payments.*', 'label' => 'Payments', 'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'],
                            ['route' => 'school.announcements.index', 'active' => 'school.announcements.*', 'label' => 'Announcements', 'icon' => 'M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z'],
                            ['route' => 'school.messages.index', 'active' => 'school.messages.*', 'label' => 'Messages', 'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.294 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v.51z'],
                        ]);
                    } elseif (auth()->user()->isParent()) {
                        $mobileNavItems = array_merge($mobileNavItems, [
                            ['route' => 'school.attendance.index', 'active' => 'school.attendance.*', 'label' => 'Attendance', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['route' => 'school.grades.index', 'active' => 'school.grades.*', 'label' => 'Grades', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
                            ['route' => 'school.homework.index', 'active' => 'school.homework.*', 'label' => 'Homework', 'icon' => 'M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184'],
                            ['route' => 'school.exams.index', 'active' => 'school.exams.*', 'label' => 'Exams', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['route' => 'school.events.index', 'active' => 'school.events.*', 'label' => 'Events', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                            ['route' => 'school.fees.index', 'active' => 'school.fees.*', 'label' => 'Fees', 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z'],
                            ['route' => 'school.payments.index', 'active' => 'school.payments.*', 'label' => 'Payments', 'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'],
                            ['route' => 'school.reports.report-card', 'active' => 'school.reports.*', 'label' => 'Report Card', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                            ['route' => 'school.announcements.index', 'active' => 'school.announcements.*', 'label' => 'Announcements', 'icon' => 'M10.34 15.84a3 3 0 11-5.66 0M9 17.25h6m-3-12.75a7.5 7.5 0 100 15 7.5 7.5 0 000-15z'],
                            ['route' => 'school.messages.index', 'active' => 'school.messages.*', 'label' => 'Messages', 'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.294 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v.51z'],
                        ]);
                    }
                @endphp

                @foreach($mobileNavItems as $item)
                    @php
                        $isActive = request()->routeIs($item['active']);
                    @endphp
                    <a href="{{ route($item['route']) }}" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition {{ $isActive ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ $isActive ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span>{{ $item['label'] }}</span>
                        @if($isActive)
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-500"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-3 border-t border-gray-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 flex items-center gap-3 animate-fade-up">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                </div>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-gray-200/60 bg-white/50 px-6 py-4 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-400 text-center sm:text-left">
            <span>&copy; {{ date('Y') }} {{ auth()->user()->school?->name ?? 'EASYSOLVE' }}</span>
            <span class="flex items-center gap-1.5 justify-center">Built by <span class="font-semibold text-brand-600">WETech Technology</span></span>
        </div>
    </footer>
    @endif

    {{-- Mobile menu toggle for student/parent layout --}}
    @if(!$isSchoolManager)
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('mobile-menu-overlay');
            const hamburger = document.querySelector('.hamburger-icon');
            const closeIcon = document.querySelector('.close-icon');
            const body = document.body;

            const isOpen = menu.style.maxHeight && menu.style.maxHeight !== '0px';

            if (isOpen) {
                // Close
                menu.style.maxHeight = '0px';
                overlay.classList.add('hidden');
                hamburger.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                body.style.overflow = '';
            } else {
                // Open
                menu.style.maxHeight = menu.scrollHeight + 'px';
                overlay.classList.remove('hidden');
                hamburger.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                body.style.overflow = 'hidden';
            }
        }

        // Close menu on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                const menu = document.getElementById('mobile-menu');
                const overlay = document.getElementById('mobile-menu-overlay');
                if (menu) menu.style.maxHeight = '0px';
                if (overlay) overlay.classList.add('hidden');
                const hamburger = document.querySelector('.hamburger-icon');
                const closeIcon = document.querySelector('.close-icon');
                if (hamburger) hamburger.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>