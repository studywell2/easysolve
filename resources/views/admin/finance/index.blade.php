@extends('layouts.admin')

@section('title', 'Financial Overview')
@section('subtitle', 'Revenue, transactions & payment insights')

@section('content')
    <div class="mb-6 animate-fade-up">
        <h1 class="text-2xl font-extrabold text-slate-800">Financial Overview</h1>
        <p class="text-sm text-slate-400 mt-0.5">Track platform revenue and subscription payments</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <!-- Total Revenue -->
        <div class="animate-fade-up delay-1 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Revenue</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ config('platform.currency_symbol', '₦') }}{{ number_format((float) $totalRevenue) }}</p>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div class="animate-fade-up delay-2 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">This Month</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ config('platform.currency_symbol', '₦') }}{{ number_format((float) $monthlyRevenue) }}</p>
                </div>
            </div>
        </div>

        <!-- This Year -->
        <div class="animate-fade-up delay-3 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-violet-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5M3.75 3h16.5M3.75 15a1.5 1.5 0 010 3M20.25 15a1.5 1.5 0 010 3M3.75 9a1.5 1.5 0 010-3M20.25 9a1.5 1.5 0 010-3"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">This Year</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ config('platform.currency_symbol', '₦') }}{{ number_format((float) $yearlyRevenue) }}</p>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="animate-fade-up delay-4 relative overflow-hidden bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-400"></div>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pending</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ config('platform.currency_symbol', '₦') }}{{ number_format((float) $pendingAmount) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Trend Chart -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 animate-fade-up delay-2">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Revenue Trend (Last 12 Months)</h3>
        @php
            $chartData = collect([]);
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $found = $monthlyData->where('month', $date->month)->where('year', $date->year)->first();
                $chartData->push([
                    'label' => $date->format('M'),
                    'total' => $found ? (float) $found->total : 0,
                ]);
            }
            $maxValue = $chartData->max('total') ?: 1;
        @endphp
        <div class="flex items-end justify-between gap-2 h-48">
            @foreach($chartData as $bar)
                <div class="flex-1 flex flex-col items-center gap-2 group">
                    <div class="w-full flex items-end justify-center" style="height: 160px;">
                        <div class="w-full max-w-[40px] bg-gradient-to-t from-brand-600 to-brand-400 rounded-t-lg transition-all duration-300 hover:from-brand-700 hover:to-brand-500 relative" style="height: {{ $bar['total'] > 0 ? max(($bar['total'] / $maxValue) * 100, 4) : 0 }}%;">
                            <span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-600 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                                {{ config('platform.currency_symbol', '₦') }}{{ number_format($bar['total']) }}
                            </span>
                        </div>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-400">{{ $bar['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm animate-fade-up delay-3 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-sm font-bold text-slate-800">Verified Transactions</h3>
        </div>
        @if($transactions->count())
        <div class="overflow-x-auto">
            <table class="w-full data-table">
                <thead>
                    <tr>
                        <th class="text-left px-6 py-3">School</th>
                        <th class="text-left px-6 py-3">Plan</th>
                        <th class="text-left px-6 py-3">Billing Cycle</th>
                        <th class="text-left px-6 py-3">Amount</th>
                        <th class="text-left px-6 py-3">Verified By</th>
                        <th class="text-left px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-brand-50/30">
                        <td class="px-6 py-3.5">
                            <a href="{{ route('admin.schools.show', $transaction->school) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">{{ $transaction->school?->name ?? '—' }}</a>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="text-sm text-slate-600">{{ $transaction->plan?->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center text-[11px] font-bold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-600 capitalize">{{ $transaction->billing_cycle }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="text-sm font-bold text-slate-800">{{ $transaction->formatted_amount }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="text-sm text-slate-600">{{ $transaction->verifier?->full_name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="text-sm text-slate-400">{{ $transaction->verified_at?->format('M j, Y') ?? '—' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
        @else
        <div class="px-6 py-16 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-sm font-medium text-slate-400">No verified transactions yet</p>
            <p class="text-xs text-slate-300 mt-1">Transactions will appear here once payment requests are verified</p>
        </div>
        @endif
    </div>
@endsection