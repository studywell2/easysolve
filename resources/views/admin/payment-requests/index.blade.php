@extends('layouts.admin')

@section('title', 'Payment Requests')
@section('subtitle', 'Verify bank transfer payments & activate subscriptions')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 animate-fade-up">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Payment Requests</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $paymentRequests->total() }} requests · {{ $pendingCount }} pending</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pending</p>
                    <p class="text-2xl font-extrabold text-amber-600">{{ \App\Models\PaymentRequest::where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Verified</p>
                    <p class="text-2xl font-extrabold text-emerald-600">{{ \App\Models\PaymentRequest::where('status', 'verified')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-rose-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-red-500 to-rose-500 flex items-center justify-center shadow-lg shadow-red-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rejected</p>
                    <p class="text-2xl font-extrabold text-red-600">{{ \App\Models\PaymentRequest::where('status', 'rejected')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6 animate-fade-up delay-1">
        <form method="GET" action="{{ route('admin.payment-requests.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by school name…"
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
            </div>
            <select name="status" class="px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition min-w-[140px]">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                Filter
            </button>
        </form>
    </div>

    <!-- Payment Requests Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-2">
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left px-6 py-4">School</th>
                        <th class="text-left px-6 py-4">Plan</th>
                        <th class="text-center px-6 py-4">Amount</th>
                        <th class="text-center px-6 py-4">Cycle</th>
                        <th class="text-center px-6 py-4">Proof</th>
                        <th class="text-center px-6 py-4">Status</th>
                        <th class="text-left px-6 py-4">Date</th>
                        <th class="text-right px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($paymentRequests as $request)
                        <tr class="group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-50 to-indigo-50 flex items-center justify-center text-brand-600 font-bold text-xs border border-brand-100/50 flex-shrink-0">
                                        {{ strtoupper(substr($request->school->name ?? '?', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $request->school->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $request->school->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 font-medium">{{ $request->plan?->name ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-slate-800">{{ $request->formatted_amount }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-1 rounded-full font-medium uppercase">{{ $request->billing_cycle }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($request->proof_of_payment)
                                    <span class="inline-flex items-center gap-1 text-xs text-brand-600 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.95 18.122a1.5 1.5 0 01-2.122-2.122L17.38 5.44"/></svg>
                                        Yes
                                    </span>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full
                                    {{ $request->isPending() ? 'bg-amber-50 text-amber-600' : ($request->isVerified() ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        {{ $request->isPending() ? 'bg-amber-500' : ($request->isVerified() ? 'bg-emerald-500' : 'bg-red-500') }}"></span>
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-400">{{ $request->created_at->format('M j, Y') }}</span>
                                <p class="text-[10px] text-slate-300">{{ $request->created_at->format('g:i A') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.payment-requests.show', $request) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 transition">
                                    @if ($request->isPending())
                                        Review
                                    @else
                                        View
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v8.25A2.25 2.25 0 004.5 15z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-400">No payment requests found</p>
                                <p class="text-xs text-slate-300 mt-1">Payment requests will appear here once schools submit them</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paymentRequests->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $paymentRequests->withQueryString()->links() }}
        </div>
        @endif
    </div>
@endsection
