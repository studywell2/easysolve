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
                                Your trial has ended. Please select a plan below to regain access to your school portal.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Available Plans --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-slate-800">Available Plans</h3>
                    <p class="text-xs text-slate-400">Choose the plan that fits your school</p>
                </div>
                <div class="p-6 grid gap-4 sm:grid-cols-3">
                    @foreach ($plans as $plan)
                        <div class="relative rounded-2xl border {{ $school->plan_id === $plan->id ? 'border-brand-500 ring-2 ring-brand-200' : 'border-gray-200' }} p-5 flex flex-col">
                            @if ($plan->is_popular)
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-600 text-white">POPULAR</span>
                            @endif
                            <p class="text-sm font-bold text-slate-900">{{ $plan->name }}</p>
                            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $plan->formatted_monthly }}</p>
                            <p class="text-xs text-slate-400">per month</p>
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
                                <a href="{{ route('plans.index') }}" class="mt-4 text-center text-xs font-semibold text-white py-2 rounded-lg bg-brand-600 hover:bg-brand-700 transition">Contact Sales</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Support --}}
            <div class="text-center text-sm text-slate-400">
                Need help choosing? <a href="{{ route('help') }}" class="text-brand-600 font-medium hover:underline">Contact our support team</a>
            </div>
        </div>
    </div>
@endsection
