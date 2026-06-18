@extends('layouts.admin')

@section('title', 'Plans')
@section('subtitle', 'Manage subscription plans available to schools')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 animate-fade-up">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Plans</h1>
            <p class="text-sm text-slate-400 mt-0.5">{{ $plans->total() }} plans configured</p>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/40 transition-all duration-200 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Plan
        </a>
    </div>

    <!-- Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($plans as $plan)
            <div class="bg-white rounded-2xl border {{ $plan->is_popular ? 'border-brand-200 ring-2 ring-brand-500/10' : 'border-gray-100' }} shadow-sm overflow-hidden animate-fade-up" style="animation-delay: {{ ($loop->index * 0.05) }}s">
                @if($plan->is_popular)
                    <div class="bg-gradient-to-r from-brand-500 to-indigo-500 px-5 py-2 text-center">
                        <span class="text-[11px] font-bold text-white uppercase tracking-wider">⭐ Most Popular</span>
                    </div>
                @endif

                <div class="p-5">
                    <!-- Plan Name & Status -->
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-800">{{ $plan->name }}</h3>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $plan->slug }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $plan->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $plan->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Pricing -->
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="text-2xl font-extrabold text-slate-800">{{ $plan->formatted_monthly }}</span>
                        <span class="text-xs text-slate-400">/month</span>
                        <span class="text-xs text-slate-400 ml-2">·</span>
                        <span class="text-sm font-semibold text-slate-600">{{ $plan->formatted_yearly }}/yr</span>
                    </div>

                    <!-- Description -->
                    @if($plan->description)
                        <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $plan->description }}</p>
                    @endif

                    <!-- Limits -->
                    <div class="flex gap-4 mb-4">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                            {{ $plan->max_students ? $plan->max_students . ' students' : 'Unlimited students' }}
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/></svg>
                            {{ $plan->max_staff ? $plan->max_staff . ' staff' : 'Unlimited staff' }}
                        </div>
                    </div>

                    <!-- Features Preview -->
                    @if($plan->features && count($plan->features) > 0)
                        <div class="space-y-1.5 mb-4">
                            @foreach(array_slice($plan->features, 0, 3) as $feature)
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $feature }}
                                </div>
                            @endforeach
                            @if(count($plan->features) > 3)
                                <p class="text-xs text-slate-400 ml-5">+ {{ count($plan->features) - 3 }} more</p>
                            @endif
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-4 border-t border-gray-50">
                        <a href="{{ route('admin.plans.edit', $plan) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 text-xs font-semibold transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" onsubmit="return confirm('Delete this plan? Schools on this plan will lose their plan reference.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition" title="Delete">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">No plans yet</p>
                    <p class="text-xs text-slate-300 mt-1">Create your first subscription plan to get started</p>
                    <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-2 mt-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Create Plan
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($plans->hasPages())
        <div class="mt-6">
            {{ $plans->withQueryString()->links() }}
        </div>
    @endif
@endsection
