@extends('layouts.school')

@section('title', 'Edit Payment')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.payments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Payments
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Edit Payment</h1>
            <p class="text-sm text-slate-400 mt-0.5">Update payment details</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.payments.update', $payment) }}">
                @csrf @method('PUT')

                <div class="bg-gray-50/80 rounded-xl p-4 mb-5 text-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><span class="text-slate-500">Student:</span> <span class="font-semibold text-slate-800">{{ $payment->student?->full_name }}</span></div>
                        <div><span class="text-slate-500">Fee:</span> <span class="font-semibold text-slate-800">{{ $payment->fee?->name }} (₦{{ number_format($payment->fee?->amount) }})</span></div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="amount" class="block text-sm font-semibold text-slate-700 mb-1.5">Amount (₦)</label>
                        <input type="number" id="amount" name="amount" min="1" step="0.01" value="{{ old('amount', $payment->amount) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="payment_method" class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <option value="cash" {{ old('payment_method', $payment->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="card" {{ old('payment_method', $payment->payment_method) === 'card' ? 'selected' : '' }}>Card</option>
                                <option value="online" {{ old('payment_method', $payment->payment_method) === 'online' ? 'selected' : '' }}>Online</option>
                                <option value="cheque" {{ old('payment_method', $payment->payment_method) === 'cheque' ? 'selected' : '' }}>Cheque</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                            <select id="status" name="status" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <option value="completed" {{ old('status', $payment->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ old('status', $payment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="partial" {{ old('status', $payment->status) === 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="failed" {{ old('status', $payment->status) === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="reference" class="block text-sm font-semibold text-slate-700 mb-1.5">Reference</label>
                            <input type="text" id="reference" name="reference" value="{{ old('reference', $payment->reference) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>
                        <div>
                            <label for="paid_at" class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Date</label>
                            <input type="date" id="paid_at" name="paid_at" value="{{ old('paid_at', $payment->paid_at?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Update Payment
                    </button>
                    <a href="{{ route('school.payments.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection