@extends('layouts.admin')

@section('title', $user->full_name)
@section('subtitle', 'User details')

@section('content')
    <!-- Back Link -->
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4 animate-fade-up">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Users
    </a>

    <!-- User Hero -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 via-brand-700 to-indigo-800 p-6 sm:p-8 mb-6 animate-fade-up">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-brand-400/20 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center text-white font-bold text-xl border border-white/20 flex-shrink-0">
                    {{ $user->initials }}
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-white">{{ $user->full_name }}</h1>
                    <p class="text-brand-200/80 text-sm mt-0.5">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full {{ $user->role === 'owner' ? 'bg-purple-500/20 text-purple-200 border border-purple-400/30' : ($user->role === 'admin' ? 'bg-blue-500/20 text-blue-200 border border-blue-400/30' : ($user->role === 'teacher' ? 'bg-cyan-500/20 text-cyan-200 border border-cyan-400/30' : ($user->role === 'student' ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-400/30' : 'bg-amber-500/20 text-amber-200 border border-amber-400/30'))) }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'owner' ? 'bg-purple-400' : ($user->role === 'admin' ? 'bg-blue-400' : ($user->role === 'teacher' ? 'bg-cyan-400' : ($user->role === 'student' ? 'bg-emerald-400' : 'bg-amber-400'))) }}"></span>
                    {{ ucfirst($user->role) }}
                </span>
                @if($user->is_active)
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Active
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full bg-red-500/20 text-red-200 border border-red-400/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        Inactive
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Info Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-1">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-sm font-bold text-slate-800">Account Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-2">
                    <span class="text-xs text-slate-400">School</span>
                    @if($user->school)
                        <a href="{{ route('admin.schools.show', $user->school) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">{{ $user->school->name }}</a>
                    @else
                        <span class="text-sm text-slate-300">—</span>
                    @endif
                </div>
                <div class="border-t border-gray-50"></div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-xs text-slate-400">Joined</span>
                    <span class="text-sm font-semibold text-slate-600">{{ $user->created_at->format('M j, Y') }}</span>
                </div>
                <div class="border-t border-gray-50"></div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-xs text-slate-400">Last Seen</span>
                    <span class="text-sm font-semibold text-slate-600">{{ $user->last_seen ? $user->last_seen->diffForHumans() : 'Never' }}</span>
                </div>
                <div class="border-t border-gray-50"></div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-xs text-slate-400">Email Verified</span>
                    <span class="text-sm font-semibold text-slate-600">{{ $user->email_verified_at ? $user->email_verified_at->format('M j, Y') : 'Not verified' }}</span>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-2">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-sm font-bold text-slate-800">Actions</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                    @csrf
                    @if($user->is_active)
                        <button type="submit" onclick="return confirm('Deactivate this user? They will no longer be able to log in.')" class="w-full inline-flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-6 py-3 rounded-xl border border-red-200 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            Deactivate User
                        </button>
                    @else
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-semibold px-6 py-3 rounded-xl border border-emerald-200 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Activate User
                        </button>
                    @endif
                </form>
                <p class="text-xs text-slate-400 mt-3 text-center">Deactivated users cannot log in until reactivated.</p>
            </div>
        </div>
    </div>
@endsection