<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Fee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $query = Payment::where('school_id', $schoolId)->with(['student', 'fee']);

        // Students only see their own payments
        if ($user->isStudent()) {
            $query->where('student_id', $user->id);
        }

        // Parents only see their children's payments
        if ($user->isParent()) {
            $childIds = $user->children()->pluck('id');
            $query->whereIn('student_id', $childIds);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $payments = $query->latest()->paginate(15)->appends($request->query());

        return view('school.payments.index', compact('payments'));
    }

    public function create()
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $students = User::where('school_id', $schoolId)->where('role', 'student')->orderBy('last_name')->get();
        $fees = Fee::where('school_id', $schoolId)->active()->get();

        return view('school.payments.create', compact('students', 'fees'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'student_id' => ['required', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'student')],
            'fee_id' => ['required', Rule::exists('fees', 'id')->where('school_id', $schoolId)],
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank_transfer,card,online,cheque',
            'reference' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,failed,partial',
            'paid_at' => 'nullable|date',
        ]);

        $fee = Fee::findOrFail($validated['fee_id']);
        $balance = max(0, $fee->amount - $validated['amount']);

        Payment::create([
            ...$validated,
            'school_id' => $schoolId,
            'balance' => $balance,
            'recorded_by' => auth()->id(),
            'paid_at' => $validated['paid_at'] ?? now(),
        ]);

        return redirect()->route('school.payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $this->authorizeAccess($payment);
        $payment->load(['student', 'fee', 'recorder']);

        return view('school.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $this->authorizeAccess($payment);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $students = User::where('school_id', $schoolId)->where('role', 'student')->orderBy('last_name')->get();
        $fees = Fee::where('school_id', $schoolId)->active()->get();

        return view('school.payments.edit', compact('payment', 'students', 'fees'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->authorizeAccess($payment);
        $this->authorizeManager();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank_transfer,card,online,cheque',
            'reference' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,failed,partial',
            'paid_at' => 'nullable|date',
        ]);

        $fee = $payment->fee;
        $balance = max(0, $fee->amount - $validated['amount']);

        $payment->update([...$validated, 'balance' => $balance]);

        return redirect()->route('school.payments.index')->with('success', 'Payment updated successfully.');
    }

    private function authorizeAccess(Payment $payment): void
    {
        if ($payment->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}