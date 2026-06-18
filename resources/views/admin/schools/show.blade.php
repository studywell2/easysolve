@extends('layouts.admin')

@section('title', $school->name)
@section('subtitle', 'School details & overview')

@section('content')
    <!-- Back Link -->
    <a href="{{ route('admin.schools.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4 animate-fade-up">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Schools
    </a>

    <!-- School Hero -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-800 p-6 sm:p-8 mb-6 animate-fade-up">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNCI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center text-white font-bold text-lg border border-white/20 flex-shrink-0">
                    {{ strtoupper(substr($school->name, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-white">{{ $school->name }}</h1>
                    <p class="text-brand-200/80 text-sm mt-0.5">{{ $school->email ?? 'No email' }} · {{ $school->phone ?? 'No phone' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($school->plan)
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-indigo-500/20 text-indigo-200 border border-indigo-400/30">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/></svg>
                        {{ $school->plan->name }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-400/30' : ($school->subscription_status === 'trial' ? 'bg-amber-500/20 text-amber-200 border border-amber-400/30' : 'bg-red-500/20 text-red-200 border border-red-400/30') }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-400' : ($school->subscription_status === 'trial' ? 'bg-amber-400' : 'bg-red-400') }}"></span>
                    {{ ucfirst($school->subscription_status) }}
                </span>
                <a href="{{ route('admin.schools.edit', $school) }}" class="inline-flex items-center gap-1.5 bg-white/15 hover:bg-white/25 backdrop-blur-sm text-white font-semibold px-4 py-2 rounded-xl border border-white/20 transition text-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Users</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $school->users_count }}</p>
                </div>
            </div>
        </div>

        <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Classes</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $school->classes_count }}</p>
                </div>
            </div>
        </div>

        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Owner</p>
                    <p class="text-lg font-bold text-slate-800 truncate">{{ $school->owner?->full_name ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $school->owner?->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users List -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-3">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-base font-bold text-slate-800">Users in this School</h2>
        </div>
        @if($school->users->count())
        <div class="divide-y divide-gray-50">
            @foreach($school->users as $user)
            <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-brand-50/30 transition">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-100 to-indigo-100 flex items-center justify-center text-brand-600 font-bold text-xs flex-shrink-0">
                    {{ $user->initials }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->full_name }}</p>
                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->role === 'owner' ? 'bg-purple-50 text-purple-600' : ($user->role === 'admin' ? 'bg-blue-50 text-blue-600' : ($user->role === 'teacher' ? 'bg-cyan-50 text-cyan-600' : ($user->role === 'student' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'))) }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'owner' ? 'bg-purple-500' : ($user->role === 'admin' ? 'bg-blue-500' : ($user->role === 'teacher' ? 'bg-cyan-500' : ($user->role === 'student' ? 'bg-emerald-500' : 'bg-amber-500'))) }}"></span>
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="px-6 py-16 text-center">
            <p class="text-sm text-slate-400">No users in this school yet</p>
        </div>
        @endif
    </div>
@endsection