@extends('layouts.school')

@section('title', 'Fees')

@section('content')
    <div class="animate-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Fees</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $isManager ? 'Manage fee structures for classes and terms' : 'Fee structures and payment status' }}</p>
            </div>
            @if($isManager)
            <a href="{{ route('school.fees.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Fee
            </a>
            @endif
        </div>

        @if($isManager)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="status" class="flex-1 min-w-[140px] px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5H14.25M14.25 4.5V9m0-4.5H21M14.25 4.5L21 9M3 19.5h6.75M9.75 19.5V15m0 4.5H3M9.75 19.5L3 15"/></svg>
                    Filter
                </button>
            </form>
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Name</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Amount</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Class</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Term</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                            @if(!$isManager)
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Payment Status</th>
                            @else
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($fees as $f)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $f->name }}</td>
                            <td class="py-3 px-4 text-slate-600 font-semibold">₦{{ number_format($f->amount) }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $f->schoolClass?->name ?? 'All Classes' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $f->term?->name ?? 'All Terms' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full {{ $f->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $f->status === 'active' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($f->status) }}
                                </span>
                            </td>
                            @if($isManager)
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('school.fees.edit', $f) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('school.fees.destroy', $f) }}" onsubmit="return confirm('Delete this fee?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @else
                            {{-- Parent: show payment status per child --}}
                            <td class="py-3 px-4">
                                @php $paymentMap = $childPaymentMap[$f->id] ?? []; @endphp
                                @foreach(auth()->user()->children as $child)
                                    @php $payment = $paymentMap[$child->id] ?? null; @endphp
                                    <div class="flex items-center gap-2 mb-1 last:mb-0">
                                        <span class="text-xs text-slate-500 truncate max-w-[100px]">{{ $child->first_name }}</span>
                                        @if($payment)
                                            @if($payment->balance > 0)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    Partial (₦{{ number_format($payment->balance) }} left)
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Paid
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Outstanding
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $isManager ? 6 : 6 }}" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">{{ $isManager ? 'No fees found' : 'No fees applicable to your children yet' }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $isManager ? 'Get started by adding a new fee structure.' : 'Fees will appear here once the school sets them up.' }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($fees->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $fees->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
