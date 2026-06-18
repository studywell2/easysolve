@extends('layouts.school')

@section('title', 'Payment Details')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.payments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Payments
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Payment Details</h1>
            <p class="text-sm text-slate-400 mt-0.5">View payment information</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <div class="space-y-1">
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Student</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $payment->student?->full_name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Fee</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $payment->fee?->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Amount Paid</span>
                    <span class="text-sm font-extrabold text-emerald-600">₦{{ number_format($payment->amount) }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Balance</span>
                    <span class="text-sm font-semibold {{ $payment->balance > 0 ? 'text-amber-600' : 'text-slate-800' }}">₦{{ number_format($payment->balance) }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Method</span>
                    <span class="text-sm font-semibold text-slate-800">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Reference</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $payment->reference ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Status</span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full {{ $payment->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($payment->status === 'partial' ? 'bg-amber-100 text-amber-700' : ($payment->status === 'pending' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700')) }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $payment->status === 'completed' ? 'bg-emerald-500' : ($payment->status === 'partial' ? 'bg-amber-500' : ($payment->status === 'pending' ? 'bg-gray-400' : 'bg-red-500')) }}"></span>
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-sm text-slate-500">Date Paid</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $payment->paid_at?->format('M d, Y h:i A') ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-slate-500">Recorded By</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $payment->recorder?->full_name ?? 'N/A' }}</span>
                </div>
            </div>

            @if(auth()->user()->canManageSchool())
            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center gap-3">
                <a href="{{ route('school.payments.edit', $payment) }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                    Edit Payment
                </a>
                <a href="{{ route('school.payments.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
            </div>
            @endif
        </div>
    </div>
@endsection