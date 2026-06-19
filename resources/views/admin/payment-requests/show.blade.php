@extends('layouts.admin')

@section('title', 'Payment Request')
@section('subtitle', 'Review & verify bank transfer payment')

@section('content')
    <a href="{{ route('admin.payment-requests.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4 animate-fade-up">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Payment Requests
    </a>

    <!-- Status Banner -->
    <div class="rounded-2xl p-5 mb-6 animate-fade-up border
        {{ $paymentRequest->isPending() ? 'bg-amber-50 border-amber-200' : ($paymentRequest->isVerified() ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200') }}">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0
                {{ $paymentRequest->isPending() ? 'bg-amber-100' : ($paymentRequest->isVerified() ? 'bg-emerald-100' : 'bg-red-100') }}">
                @if ($paymentRequest->isPending())
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @elseif ($paymentRequest->isVerified())
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                @endif
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800 capitalize">{{ $paymentRequest->status }}</p>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if ($paymentRequest->isPending())
                        This request is awaiting your review.
                    @elseif ($paymentRequest->isVerified())
                        Verified by {{ $paymentRequest->verifier?->full_name ?? 'Admin' }} on {{ $paymentRequest->verified_at?->format('M j, Y \a\t g:i A') }}
                                    · Subscription active until {{ $paymentRequest->subscription?->ends_at?->format('M j, Y') }}
                    @else
                        Rejected by {{ $paymentRequest->verifier?->full_name ?? 'Admin' }} on {{ $paymentRequest->verified_at?->format('M j, Y \a\t g:i A') }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- School & Plan Info -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-1">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-base font-bold text-slate-800">Payment Details</h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- School -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <span class="text-sm text-slate-500">School</span>
                        <div class="text-right">
                            <a href="{{ route('admin.schools.show', $paymentRequest->school) }}" class="text-sm font-semibold text-brand-600 hover:underline">{{ $paymentRequest->school->name }}</a>
                            <p class="text-xs text-slate-400">{{ $paymentRequest->school->email ?? 'No email' }}</p>
                        </div>
                    </div>
                    <!-- Plan -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <span class="text-sm text-slate-500">Plan</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $paymentRequest->plan?->name ?? '—' }}</span>
                    </div>
                    <!-- Billing Cycle -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <span class="text-sm text-slate-500">Billing Cycle</span>
                        <span class="text-sm font-semibold text-slate-800 capitalize">{{ $paymentRequest->billing_cycle }}</span>
                    </div>
                    <!-- Amount -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <span class="text-sm text-slate-500">Amount</span>
                        <span class="text-lg font-extrabold text-brand-600">{{ $paymentRequest->formatted_amount }}</span>
                    </div>
                    <!-- Date -->
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm text-slate-500">Submitted</span>
                        <span class="text-sm text-slate-600">{{ $paymentRequest->created_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes from School -->
            @if ($paymentRequest->notes)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-2">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-base font-bold text-slate-800">Notes from School</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $paymentRequest->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Proof of Payment -->
            @if ($paymentRequest->proof_of_payment)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-2">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-800">Proof of Payment</h2>
                    <a href="{{ asset('storage/' . $paymentRequest->proof_of_payment) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 px-3 py-1.5 rounded-lg hover:bg-brand-100 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        Open Full
                    </a>
                </div>
                <div class="p-6 flex items-center justify-center bg-gray-50/50">
                    @php
                        $ext = pathinfo($paymentRequest->proof_of_payment, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp
                    @if ($isImage)
                        <img src="{{ asset('storage/' . $paymentRequest->proof_of_payment) }}" alt="Proof of Payment" class="max-w-full max-h-96 rounded-xl shadow-md">
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-slate-600">PDF Document</p>
                            <a href="{{ asset('storage/' . $paymentRequest->proof_of_payment) }}" target="_blank" class="text-xs text-brand-600 hover:underline mt-1 inline-block">Click to view</a>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Admin Notes (if processed) -->
            @if ($paymentRequest->admin_notes && !$paymentRequest->isPending())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-3">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-base font-bold text-slate-800">Admin Notes</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $paymentRequest->admin_notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Action Panel -->
        <div class="space-y-6">

            @if ($paymentRequest->isPending())
                <!-- Verify Action -->
                <div class="bg-white rounded-2xl border border-emerald-200 shadow-sm overflow-hidden animate-fade-up delay-1 ring-2 ring-emerald-100">
                    <div class="px-6 py-5 border-b border-gray-100 bg-emerald-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Verify & Activate</h3>
                                <p class="text-xs text-slate-400">Confirm payment and activate subscription</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.payment-requests.verify', $paymentRequest) }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-4">
                            <!-- Activation Preview -->
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500">Plan</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $paymentRequest->plan?->name }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500">Cycle</span>
                                    <span class="text-sm font-semibold text-slate-800 capitalize">{{ $paymentRequest->billing_cycle }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500">Starts</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ now()->format('M j, Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-500">Expires</span>
                                    <span class="text-sm font-bold text-emerald-600">
                                        @php
                                            $expiry = $paymentRequest->billing_cycle === 'yearly' ? now()->addYear() : now()->addMonth();
                                        @endphp
                                        {{ $expiry->format('M j, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label for="verify_notes" class="block text-xs font-semibold text-slate-700 mb-1.5">Admin Notes <span class="text-slate-400 font-normal">(optional)</span></label>
                                <textarea name="admin_notes" id="verify_notes" rows="3" placeholder="e.g. Confirmed transfer of ₦{{ number_format($paymentRequest->amount) }} received…" class="w-full px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/10 transition resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-emerald-600/25 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Verify & Activate Subscription
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reject Action -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-2">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Reject Payment</h3>
                                <p class="text-xs text-slate-400">Decline this payment request</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.payment-requests.reject', $paymentRequest) }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="reject_notes" class="block text-xs font-semibold text-slate-700 mb-1.5">Reason for Rejection <span class="text-red-500">*</span></label>
                                <textarea name="admin_notes" id="reject_notes" rows="3" required placeholder="e.g. Payment not received, amount mismatch…" class="w-full px-3 py-2 bg-gray-50/80 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-500/10 transition resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-6 py-2.5 rounded-xl border border-red-200 transition text-sm">
                                Reject Payment Request
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Processed Status -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden animate-fade-up delay-1">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-slate-800">Request Processed</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if ($paymentRequest->isVerified() && $paymentRequest->subscription)
                            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-sm font-bold text-emerald-700">Subscription Active</span>
                                </div>
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500">Started</span>
                                        <span class="font-medium text-slate-700">{{ $paymentRequest->subscription->starts_at?->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500">Expires</span>
                                        <span class="font-medium text-slate-700">{{ $paymentRequest->subscription->ends_at?->format('M j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('admin.schools.show', $paymentRequest->school) }}" class="block text-center text-sm font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 py-2.5 rounded-lg transition">
                            View School Details
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
