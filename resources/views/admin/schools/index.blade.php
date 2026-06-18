@extends('layouts.admin')

@section('title', 'Schools')
@section('subtitle', 'Manage all registered schools on the platform')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 animate-fade-up">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Schools</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $schools->total() }} schools registered</p>
        </div>
        <a href="{{ route('admin.schools.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all duration-200 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add School
        </a>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6 animate-fade-up delay-1">
        <form method="GET" action="{{ route('admin.schools.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search schools by name or email…"
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <select name="status" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition min-w-[140px]">
                <option value="">All Status</option>
                <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>Trial</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                Filter
            </button>
        </form>
    </div>

    <!-- Schools Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-2">
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left px-6 py-4">School</th>
                        <th class="text-left px-6 py-4">Owner</th>
                        <th class="text-center px-6 py-4">Users</th>
                        <th class="text-center px-6 py-4">Status</th>
                        <th class="text-right px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($schools as $school)
                        <tr class="group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center text-brand-600 font-bold text-xs border border-brand-100/50 flex-shrink-0 group-hover:scale-105 transition-transform">
                                        {{ strtoupper(substr($school->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $school->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $school->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600">{{ $school->owner?->full_name ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">{{ $school->users_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-50 text-emerald-600' : ($school->subscription_status === 'trial' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $school->subscription_status === 'active' ? 'bg-emerald-500' : ($school->subscription_status === 'trial' ? 'bg-amber-500' : 'bg-red-500') }}"></span>
                                    {{ ucfirst($school->subscription_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.schools.show', $school) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 transition">
                                        View
                                    </a>
                                    <a href="{{ route('admin.schools.edit', $school) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-400">No schools found</p>
                                <p class="text-xs text-slate-300 mt-1">Try adjusting your search or filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schools->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $schools->withQueryString()->links() }}
        </div>
        @endif
    </div>
@endsection