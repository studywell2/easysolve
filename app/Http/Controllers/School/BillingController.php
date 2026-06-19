<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillingController extends Controller
{
    /**
     * Show the school's subscription/billing status.
     */
    public function index()
    {
        $school = auth()->user()->school;
        $plans = Plan::active()->get();
        $paymentRequests = $school->paymentRequests()
            ->with(['plan', 'verifier'])
            ->latest()
            ->take(10)
            ->get();

        $bankDetails = config('platform.bank');

        return view('school.billing.index', compact('school', 'plans', 'paymentRequests', 'bankDetails'));
    }

    /**
     * Store a new bank transfer payment request.
     */
    public function store(Request $request)
    {
        $school = auth()->user()->school;

        $validated = $request->validate([
            'plan_id' => ['required', Rule::exists('plans', 'id')->where('is_active', true)],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'proof_of_payment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $amount = $validated['billing_cycle'] === 'yearly'
            ? $plan->price_yearly
            : $plan->price_monthly;

        // Store proof of payment if uploaded
        $proofPath = null;
        if ($request->hasFile('proof_of_payment')) {
            $proofPath = $request->file('proof_of_payment')
                ->store('payment-proofs', 'public');
        }

        PaymentRequest::create([
            'school_id' => $school->id,
            'plan_id' => $validated['plan_id'],
            'billing_cycle' => $validated['billing_cycle'],
            'amount' => $amount,
            'proof_of_payment' => $proofPath,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('school.billing.index')
            ->with('success', 'Your payment request has been submitted. We will verify it and activate your subscription shortly.');
    }
}