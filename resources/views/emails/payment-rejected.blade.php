@component('mail::message')
# Payment Request Update

Hello **{{ $paymentRequest->school->owner?->full_name ?? 'there' }}**,

Unfortunately, your recent payment request could not be verified. Below are the details:

---

### Payment Details

| Field | Value |
|-------|-------|
| **School** | {{ $paymentRequest->school->name }} |
| **Plan** | {{ $paymentRequest->plan->name }} |
| **Amount** | {{ $paymentRequest->formatted_amount }} |
| **Status** | Rejected |

### Reason

{{ $paymentRequest->admin_notes }}

---

If you believe this is an error or have questions, please contact our support team. You can also submit a new payment request from your billing page.

@component('mail::button', ['url' => config('app.url') . '/school/billing'])
Go to Billing
@endcomponent

---

*Thank you for your understanding.*
@endcomponent
