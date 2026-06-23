@extends('layouts.admin')

@section('title', 'Users')
@section('subtitle', 'View & manage users across all schools')

@section('content')
    <div class="mb-6 animate-fade-up">
        <h1 class="text-2xl font-extrabold text-slate-800">Users</h1>
        <p class="text-sm text-slate-400 mt-0.5">Manage users across all schools on the platform</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6 animate-fade-up delay-1">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email…"
                    class="w-full pl-9 pr-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <select name="school" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                <option value="">All Schools</option>
                @foreach($schools as $id => $name)
                    <option value="{{ $id }}" {{ (string) request('school') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <select name="role" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                <option value="">All Roles</option>
                <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="parent" {{ request('role') === 'parent' ? 'selected' : '' }}>Parent</option>
            </select>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/></svg>
                Filter
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-2 overflow-hidden">
        @if($users->count())
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left px-6 py-3">User</th>
                        <th class="text-left px-6 py-3">School</th>
                        <th class="text-left px-6 py-3">Role</th>
                        <th class="text-left px-6 py-3">Status</th>
                        <th class="text-right px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-brand-50/30">
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
                                <a href="{{ route('admin.schools.show', $user->school) }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">{{ $user->school->name }}</a>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->role === 'owner' ? 'bg-purple-50 text-purple-600' : ($user->role === 'admin' ? 'bg-blue-50 text-blue-600' : ($user->role === 'teacher' ? 'bg-cyan-50 text-cyan-600' : ($user->role === 'student' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'))) }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'owner' ? 'bg-purple-500' : ($user->role === 'admin' ? 'bg-blue-500' : ($user->role === 'teacher' ? 'bg-cyan-500' : ($user->role === 'student' ? 'bg-emerald-500' : 'bg-amber-500'))) }}"></span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full bg-red-50 text-red-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                                    @csrf @method('POST')
                                    @if($user->is_active)
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Deactivate" onclick="return confirm('Deactivate this user?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        </button>
                                    @else
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Activate">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @else
        <div class="px-6 py-16 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-400">No users found</p>
            <p class="text-xs text-slate-300 mt-1">Try adjusting your filters</p>
        </div>
        @endif
    </div>
@endsection