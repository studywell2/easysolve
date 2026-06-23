<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $totalRevenue = PaymentRequest::where('status', 'verified')->sum('amount');
        $monthlyRevenue = PaymentRequest::where('status', 'verified')
            ->whereMonth('verified_at', now()->month)
            ->whereYear('verified_at', now()->year)
            ->sum('amount');
        $yearlyRevenue = PaymentRequest::where('status', 'verified')
            ->whereYear('verified_at', now()->year)
            ->sum('amount');

        $monthlyData = PaymentRequest::where('status', 'verified')
            ->where('verified_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw('MONTH(verified_at) as month, YEAR(verified_at) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $transactions = PaymentRequest::with(['school', 'plan', 'verifier'])
            ->where('status', 'verified')
            ->latest('verified_at')
            ->paginate(15);

        $pendingAmount = PaymentRequest::where('status', 'pending')->sum('amount');

        return view('admin.finance.index', compact(
            'totalRevenue', 'monthlyRevenue', 'yearlyRevenue',
            'monthlyData', 'transactions', 'pendingAmount'
        ));
    }
}
