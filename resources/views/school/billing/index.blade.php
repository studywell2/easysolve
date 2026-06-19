@extends('layouts.school')

@section('title', 'Billing & Subscription')

@section('content')
    <div class="animate-fade-up">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Billing & Subscription</h1>
            <p class="text-sm text-slate-400 mt-0.5">Manage your school's subscription plan</p>
        </div>

        <div class="max-w-4xl space-y-6">

            {{-- Current Status --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v8.25A2.25 2.25 0 004.5 15z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Current Plan</h3>
                            <p class="text-xs text-slate-400">Your subscription status</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-3xl font-extrabold text-slate-900">{{ $school->plan?->name ?? 'No Plan' }}</p>
                            <p class="text-sm text-slate-500 mt-1">
                                @if ($school->isOnTrial())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Trial — {{ $school->trialDaysLeft() }} days left
                                    </span>
                                @elseif ($school->hasActiveSubscription())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Active
                                    </span>
                                    @php $activeSub = $school->subscriptions()->where('status', 'active')->latest('ends_at')->first(); @endphp
                                    @if ($activeSub?->ends_at)
                                        <span class="text-xs text-slate-400 ml-2">expires {{ $activeSub->ends_at->format('M j, Y') }}</span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Expired
                                    </span>
                                @endif
                            </p>
                        </div>
                        @if ($school->plan)
                            <div class="text-right">
                                <p class="text-2xl font-bold text-slate-900">{{ $school->plan->formatted_monthly }}</p>
                                <p class="text-xs text-slate-400">per month</p>
                            </div>
                        @endif
                    </div>

                    @if ($school->isOnTrial() && $school->trialDaysLeft() <= 3)
                        <div class="mt-4 p-4 rounded-xl bg-amber-50 border border-amber-200">
                            <p class="text-sm text-amber-800 font-medium">
                                ⚠️ Your trial ends in {{ $school->trialDaysLeft() }} day(s). Choose a plan to avoid interruption.
                            </p>
                        </div>
                    @endif

                    @if (!$school->isOnTrial() && !$school->hasActiveSubscription())
                        <div class="mt-4 p-4 rounded-xl bg-red-50 border border-red-200">
                            <p class="text-sm text-red-800 font-medium">
                                Your trial has ended. Please select a plan below and make payment to regain access to your school portal.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bank Transfer Details --}}
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v8.25A2.25 2.25 0 004.5 15z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">Bank Transfer Details</h3>
                            <p class="text-xs text-slate-400">Transfer your subscription fee to this account</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Bank</p>
                            <p class="text-sm font-semibold text-white mt-1">{{ $bankDetails['name'] }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Account Name</p>
                            <p class="text-sm font-semibold text-white mt-1">{{ $bankDetails['account_name'] }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Account Number</p>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-sm font-bold text-amber-400 font-mono tracking-wider">{{ $bankDetails['account_number'] }}</p>
                                <button onclick="copyAccountNumber()" class="text-slate-400 hover:text-white transition" title="Copy account number">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if ($bankDetails['transfer_note'])
                        <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20">
                            <p class="text-xs text-amber-300 flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                {{ $bankDetails['transfer_note'] }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Available Plans --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Available Plans</h3>
                            <p class="text-xs text-slate-400">Choose a plan and make payment</p>
                        </div>
                        {{-- Billing Cycle Toggle --}}
                        <div class="inline-flex items-center rounded-xl bg-gray-100 p-1 gap-1">
                            <button id="cycle-monthly" onclick="switchCycle('monthly')" class="px-4 py-1.5 rounded-lg text-xs font-semibold bg-white text-slate-800 shadow-sm transition-all duration-200">
                                Monthly
                            </button>
                            <button id="cycle-yearly" onclick="switchCycle('yearly')" class="px-4 py-1.5 rounded-lg text-xs font-semibold text-slate-500 transition-all duration-200">
                                Yearly
                                <span class="ml-1 text-[9px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">Save 2 months</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6 grid gap-4 sm:grid-cols-3" id="plans-grid">
                    @foreach ($plans as $plan)
                        <div class="plan-card relative rounded-2xl border {{ $school->plan_id === $plan->id ? 'border-brand-500 ring-2 ring-brand-200' : 'border-gray-200' }} p-5 flex flex-col" data-plan-id="{{ $plan->id }}" data-plan-name="{{ $plan->name }}" data-price-monthly="{{ $plan->formatted_monthly }}" data-price-yearly="{{ $plan->formatted_yearly }}" data-amount-monthly="{{ $plan->price_monthly }}" data-amount-yearly="{{ $plan->price_yearly }}">
                            @if ($plan->is_popular)
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-600 text-white">POPULAR</span>
                            @endif
                            <p class="text-sm font-bold text-slate-900">{{ $plan->name }}</p>
                            <div class="mt-2">
                                <p class="text-2xl font-extrabold text-slate-900 plan-price" data-cycle="monthly">{{ $plan->formatted_monthly }}</p>
                                <p class="text-xs text-slate-400 plan-price-label">per month</p>
                            </div>
                            <ul class="mt-4 space-y-1.5 flex-1">
                                @foreach (($plan->features ?? []) as $feature)
                                    <li class="text-xs text-slate-600 flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-brand-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                            @if ($school->plan_id === $plan->id)
                                <span class="mt-4 text-center text-xs font-semibold text-brand-600 py-2 rounded-lg bg-brand-50">Current Plan</span>
                            @else
                                <button type="button" onclick="openPaymentForm('{{ $plan->id }}', '{{ $plan->name }}')" class="mt-4 w-full text-center text-xs font-semibold text-white py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 transition flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                                    Select Plan
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Payment Request Form (Hidden by default) --}}
            <div id="payment-form-card" class="hidden bg-white rounded-2xl border border-brand-200 shadow-sm overflow-hidden ring-2 ring-brand-100">
                <form action="{{ route('school.billing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Confirm Your Payment</h3>
                                <p class="text-xs text-slate-400">Submit this form after making your bank transfer</p>
                            </div>
                        </div>
                        <button type="button" onclick="closePaymentForm()" class="text-slate-400 hover:text-slate-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-5">
                        {{-- Selected Plan Summary --}}
                        <input type="hidden" name="plan_id" id="form-plan-id" value="">
                        <input type="hidden" name="billing_cycle" id="form-billing-cycle" value="monthly">
                        <div class="p-4 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-500">Selected Plan</p>
                                <p class="text-lg font-bold text-slate-900" id="form-plan-name">—</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500">Amount Due</p>
                                <p class="text-lg font-extrabold text-brand-600" id="form-amount">—</p>
                                <p class="text-[10px] text-slate-400" id="form-cycle-label">per month</p>
                            </div>
                        </div>

                        {{-- Billing Cycle --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Billing Cycle</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="billing_cycle_radio" value="monthly" checked onchange="updateCycle('monthly')" class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-gray-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 transition">
                                        <p class="text-sm font-semibold text-slate-700">Monthly</p>
                                        <p class="text-xs text-slate-400" id="monthly-amount">—</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="billing_cycle_radio" value="yearly" onchange="updateCycle('yearly')" class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-gray-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 transition">
                                        <p class="text-sm font-semibold text-slate-700">Yearly</p>
                                        <p class="text-xs text-slate-400" id="yearly-amount">—</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Proof of Payment --}}
                        <div>
                            <label for="proof_of_payment" class="block text-sm font-semibold text-slate-700 mb-2">Proof of Payment <span class="text-slate-400 font-normal">(optional)</span></label>
                            <div class="relative">
                                <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/jpeg,image/png,application/pdf" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 file:cursor-pointer cursor-pointer border border-gray-200 rounded-xl focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                                <p class="text-[11px] text-slate-400 mt-1.5">Upload a screenshot or receipt (JPG, PNG, PDF — max 5MB)</p>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Additional Notes <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea name="notes" id="notes" rows="3" placeholder="e.g. Transfer reference number, date of payment…" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition resize-none"></textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-brand-600/25 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                I've Made Payment — Submit
                            </button>
                            <button type="button" onclick="closePaymentForm()" class="px-6 py-3 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-700 hover:bg-gray-50 transition">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Payment Request History --}}
            @if ($paymentRequests->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-slate-800">Payment History</h3>
                    <p class="text-xs text-slate-400">Your recent payment requests</p>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ($paymentRequests as $request)
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-brand-50/30 transition">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                {{ $request->isPending() ? 'bg-amber-50' : ($request->isVerified() ? 'bg-emerald-50' : 'bg-red-50') }}">
                                @if ($request->isPending())
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif ($request->isVerified())
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-slate-800">{{ $request->plan?->name }}</p>
                                    <span class="text-[10px] text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded-full font-medium uppercase">{{ $request->billing_cycle }}</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $request->formatted_amount }} · {{ $request->created_at->format('M j, Y \a\t g:i A') }}
                                </p>
                                @if ($request->isRejected() && $request->admin_notes)
                                    <p class="text-xs text-red-500 mt-1">⚠ {{ $request->admin_notes }}</p>
                                @endif
                                @if ($request->isVerified())
                                    <p class="text-xs text-emerald-600 mt-1">✓ Verified by {{ $request->verifier?->full_name ?? 'Admin' }} on {{ $request->verified_at?->format('M j, Y') }}</p>
                                @endif
                                @if ($request->isPending())
                                    <p class="text-xs text-amber-600 mt-1">Awaiting verification…</p>
                                @endif
                            </div>
                            <div>
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full
                                    {{ $request->isPending() ? 'bg-amber-50 text-amber-600' : ($request->isVerified() ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600') }}">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        {{ $request->isPending() ? 'bg-amber-500' : ($request->isVerified() ? 'bg-emerald-500' : 'bg-red-500') }}"></span>
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Support --}}
            <div class="text-center text-sm text-slate-400">
                Need help? <a href="{{ route('help') }}" class="text-brand-600 font-medium hover:underline">Contact our support team</a>
            </div>
        </div>
    </div>

    <script>
        let currentCycle = 'monthly';

        function switchCycle(cycle) {
            currentCycle = cycle;

            // Update toggle buttons
            document.getElementById('cycle-monthly').className = cycle === 'monthly'
                ? 'px-4 py-1.5 rounded-lg text-xs font-semibold bg-white text-slate-800 shadow-sm transition-all duration-200'
                : 'px-4 py-1.5 rounded-lg text-xs font-semibold text-slate-500 transition-all duration-200';
            document.getElementById('cycle-yearly').className = cycle === 'yearly'
                ? 'px-4 py-1.5 rounded-lg text-xs font-semibold bg-white text-slate-800 shadow-sm transition-all duration-200'
                : 'px-4 py-1.5 rounded-lg text-xs font-semibold text-slate-500 transition-all duration-200';

            // Update plan prices
            document.querySelectorAll('.plan-card').forEach(card => {
                const priceEl = card.querySelector('.plan-price');
                const labelEl = card.querySelector('.plan-price-label');
                if (cycle === 'yearly') {
                    priceEl.textContent = card.dataset.priceYearly;
                    labelEl.textContent = 'per year';
                } else {
                    priceEl.textContent = card.dataset.priceMonthly;
                    labelEl.textContent = 'per month';
                }
            });

            // Update form if open
            updateCycle(cycle);
        }

        function openPaymentForm(planId, planName) {
            const card = document.querySelector(`[data-plan-id="${planId}"]`);
            if (!card) return;

            document.getElementById('form-plan-id').value = planId;
            document.getElementById('form-plan-name').textContent = planName;

            // Set billing cycle radio
            document.querySelector(`input[name="billing_cycle_radio"][value="${currentCycle}"]`).checked = true;

            updateCycle(currentCycle);

            const formCard = document.getElementById('payment-form-card');
            formCard.classList.remove('hidden');
            formCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function closePaymentForm() {
            document.getElementById('payment-form-card').classList.add('hidden');
        }

        function updateCycle(cycle) {
            const planId = document.getElementById('form-plan-id').value;
            if (!planId) return;

            const card = document.querySelector(`[data-plan-id="${planId}"]`);
            if (!card) return;

            const amount = cycle === 'yearly' ? card.dataset.amountYearly : card.dataset.amountMonthly;
            const symbol = '{{ config('platform.currency_symbol', '₦') }}';
            const formattedAmount = parseFloat(amount) > 0
                ? symbol + new Intl.NumberFormat().format(parseFloat(amount))
                : 'Free';

            document.getElementById('form-amount').textContent = formattedAmount;
            document.getElementById('form-cycle-label').textContent = cycle === 'yearly' ? 'per year' : 'per month';
            document.getElementById('form-billing-cycle').value = cycle;

            // Update monthly/yearly amount labels
            document.getElementById('monthly-amount').textContent = card.dataset.priceMonthly + ' / month';
            document.getElementById('yearly-amount').textContent = card.dataset.priceYearly + ' / year';

            // Sync the toggle
            document.querySelector(`input[name="billing_cycle_radio"][value="${cycle}"]`).checked = true;
        }

        function copyAccountNumber() {
            const number = '{{ $bankDetails['account_number'] }}';
            navigator.clipboard.writeText(number).then(() => {
                // Brief visual feedback
                const btn = event.currentTarget;
                const original = btn.innerHTML;
                btn.innerHTML = '<svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>';
                setTimeout(() => { btn.innerHTML = original; }, 1500);
            });
        }
    </script>
@endsection