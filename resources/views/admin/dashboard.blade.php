@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Platform overview & management')

@section('content')
    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-800 p-6 sm:p-8 mb-8 animate-fade-up">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNCI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-indigo-400/15 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Welcome back, {{ auth()->user()->first_name }}</h1>
                <p class="text-brand-200/80 mt-1 text-sm">Here's what's happening across your platform today.</p>
            </div>
            <a href="{{ route('admin.schools.create', ['setup' => 1]) }}" class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm text-white font-semibold px-5 py-2.5 rounded-xl border border-white/20 transition-all duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add School
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Total Schools -->
        <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Schools</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalSchools }}</p>
                    <p class="text-xs text-slate-400 mt-1">Registered platforms</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/25 stat-glow-blue">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-violet-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalUsers }}</p>
                    <p class="text-xs text-slate-400 mt-1">Across all schools</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-500/25 stat-glow-purple">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Schools -->
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Schools</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $activeSchools }}</p>
                    <p class="text-xs text-slate-400 mt-1">Paid subscriptions</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/25 stat-glow-emerald">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Trial Schools -->
        <div class="animate-fade-up delay-4 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Trial Schools</p>
                    <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ $trialSchools }}</p>
                    <p class="text-xs text-slate-400 mt-1">Evaluating platform</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25 stat-glow-amber">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Schools — 2 cols -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-2">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Recent Schools</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Latest registrations on the platform</p>
                </div>
                <a href="{{ route('admin.schools.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                    View all
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            @if($recentSchools->count())
            <div class="divide-y divide-gray-50">
                @foreach($recentSchools as $school)
                <a href="{{ route('admin.schools.show', $school) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-brand-50/30 transition group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center text-brand-600 font-bold text-sm border border-brand-100/50 flex-shrink-0 group-hover:scale-105 transition-transform">
                        {{ strtoupper(substr($school->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-brand-700 transition">{{ $school->name }}</p>
                        <p class="text-xs text-slate-400">{{ $school->email ?? 'No email' }} · {{ $school->users_count }} users</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-50 text-emerald-600' : ($school->subscription_status === 'trial' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-500' : ($school->subscription_status === 'trial' ? 'bg-amber-500' : 'bg-red-500') }}"></span>
                            {{ ucfirst($school->subscription_status) }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="px-6 py-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-400">No schools yet</p>
                <p class="text-xs text-slate-300 mt-1">Schools will appear here once they register</p>
            </div>
            @endif
        </div>

        <!-- Platform Stats — 1 col -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-3">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-slate-800">Platform Health</h2>
                <p class="text-xs text-slate-400 mt-0.5">Key metrics at a glance</p>
            </div>
            <div class="p-6 space-y-5">
                <!-- Subscription Distribution -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500">Active Subscriptions</span>
                        <span class="text-xs font-bold text-emerald-600">{{ $totalSchools > 0 ? round(($activeSchools / $totalSchools) * 100) : 0 }}%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-500" style="width: {{ $totalSchools > 0 ? ($activeSchools / $totalSchools) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500">Trial Conversions</span>
                        <span class="text-xs font-bold text-amber-600">{{ $trialSchools }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-500 to-orange-400 rounded-full transition-all duration-500" style="width: {{ $totalSchools > 0 ? ($trialSchools / $totalSchools) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500">Expired</span>
                        <span class="text-xs font-bold text-red-600">{{ $totalSchools - $activeSchools - $trialSchools }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        @php $expiredPct = $totalSchools > 0 ? (($totalSchools - $activeSchools - $trialSchools) / $totalSchools) * 100 : 0 @endphp
                        <div class="h-full bg-gradient-to-r from-red-500 to-rose-400 rounded-full transition-all duration-500" style="width: {{ max(0, $expiredPct) }}%"></div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 pt-5">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="w-9 h-9 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700">Avg Users/School</p>
                            <p class="text-lg font-extrabold text-slate-800">{{ $totalSchools > 0 ? round($totalUsers / $totalSchools) : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-4 mt-6">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Recent Users</h2>
                <p class="text-xs text-slate-400 mt-0.5">Latest users registered across all schools</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                {{ $totalUsers }} total
            </span>
        </div>

        @if($recentUsers->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-3">User</th>
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-3">School</th>
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-3">Role</th>
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-3">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentUsers as $user)
                    <tr class="hover:bg-brand-50/30 transition">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-100 to-indigo-100 flex items-center justify-center text-brand-600 font-bold text-xs flex-shrink-0">
                                    {{ $user->initials }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->full_name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            @if($user->school)
                                <span class="text-sm text-slate-600">{{ $user->school->name }}</span>
                            @else
                                <span class="text-xs text-slate-300 italic">Platform-level</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->role === 'owner' ? 'bg-purple-50 text-purple-600' : ($user->role === 'admin' ? 'bg-blue-50 text-blue-600' : ($user->role === 'teacher' ? 'bg-cyan-50 text-cyan-600' : ($user->role === 'student' ? 'bg-emerald-50 text-emerald-600' : ($user->role === 'parent' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-600')))) }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'owner' ? 'bg-purple-500' : ($user->role === 'admin' ? 'bg-blue-500' : ($user->role === 'teacher' ? 'bg-cyan-500' : ($user->role === 'student' ? 'bg-emerald-500' : ($user->role === 'parent' ? 'bg-amber-500' : 'bg-slate-400')))) }}"></span>
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="text-xs text-slate-400">{{ $user->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-slate-400">No users yet</p>
            <p class="text-xs text-slate-300 mt-1">Users will appear here once they register</p>
        </div>
        @endif
    </div>
@endsection