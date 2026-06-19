<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentRequest::with(['school.owner', 'plan', 'verifier']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('school', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $paymentRequests = $query->latest()->paginate(15)->appends($request->query());

        $pendingCount = PaymentRequest::where('status', 'pending')->count();

        return view('admin.payment-requests.index', compact('paymentRequests', 'pendingCount'));
    }

    public function show(PaymentRequest $paymentRequest)
    {
        $paymentRequest->load(['school.owner', 'school.plan', 'plan', 'verifier', 'subscription']);

        return view('admin.payment-requests.show', compact('paymentRequest'));
    }

    public function verify(Request $request, PaymentRequest $paymentRequest)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if (!$paymentRequest->isPending()) {
            return back()->with('error', 'This payment request has already been processed.');
        }

        $startsAt = now();
        $endsAt = $paymentRequest->billing_cycle === 'yearly'
            ? $startsAt->copy()->addYear()
            : $startsAt->copy()->addMonth();

        // Create the subscription record
        $subscription = Subscription::create([
            'school_id' => $paymentRequest->school_id,
            'plan_id' => $paymentRequest->plan_id,
            'status' => 'active',
            'billing_cycle' => $paymentRequest->billing_cycle,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ]);

        // Update the school's denormalized fields
        $paymentRequest->school->update([
            'subscription_status' => 'active',
            'plan_id' => $paymentRequest->plan_id,
        ]);

        // Mark the payment request as verified
        $paymentRequest->update([
            'status' => 'verified',
            'admin_notes' => $validated['admin_notes'] ?? null,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'subscription_id' => $subscription->id,
        ]);

        return redirect()->route('admin.payment-requests.index')
            ->with('success', "Subscription activated for {$paymentRequest->school->name}. Valid until {$endsAt->format('M j, Y')}.");
    }

    public function reject(Request $request, PaymentRequest $paymentRequest)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        if (!$paymentRequest->isPending()) {
            return back()->with('error', 'This payment request has already been processed.');
        }

        $paymentRequest->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.payment-requests.index')
            ->with('success', "Payment request for {$paymentRequest->school->name} has been rejected.");
    }
}
