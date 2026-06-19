@component('mail::message')
# {{ $forAdmin ? 'New Payment Request' : 'Payment Request Received' }}

Hello **{{ $forAdmin ? 'Admin' : ($paymentRequest->school->owner?->full_name ?? 'there') }}**,

@if($forAdmin)
A new payment request has been submitted by **{{ $paymentRequest->school->name }}** and is pending your review.
@else
We've received your payment request for **{{ $paymentRequest->plan->name }}**. Our team will verify your bank transfer and activate your subscription shortly.
@endif

---

### Payment Details

| Field | Value |
|-------|-------|
| **School** | {{ $paymentRequest->school->name }} |
| **Plan** | {{ $paymentRequest->plan->name }} |
| **Billing Cycle** | {{ ucfirst($paymentRequest->billing_cycle) }} |
| **Amount** | {{ $paymentRequest->formatted_amount }} |
| **Proof of Payment** | {{ $paymentRequest->proof_of_payment ? 'Uploaded' : 'Not provided' }} |
| **Status** | Pending Review |

@if($paymentRequest->notes)
**Notes from school:**
{{ $paymentRequest->notes }}
@endif

@if($forAdmin)
@component('mail::button', ['url' => config('app.url') . '/admin/payment-requests/' . $paymentRequest->id])
Review Payment Request
@endcomponent
@else
@component('mail::button', ['url' => config('app.url') . '/school/billing'])
View Billing Status
@endcomponent
@endif

---

@if(!$forAdmin)
*You will receive another email once your payment has been verified. If you have any questions, please contact our support team.*
@else
*Please log in to the admin panel to verify or reject this request.*
@endif
@endcomponent
