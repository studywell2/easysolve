@component('mail::message')
# Subscription Activated! 🎉

Hello **{{ $subscription->school->owner?->full_name ?? 'there' }}**,

Great news! Your payment has been verified and your subscription is now **active**.

---

### Subscription Details

| Field | Value |
|-------|-------|
| **School** | {{ $subscription->school->name }} |
| **Plan** | {{ $subscription->plan->name }} |
| **Billing Cycle** | {{ ucfirst($subscription->billing_cycle) }} |
| **Start Date** | {{ $subscription->starts_at->format('F j, Y') }} |
| **Expiry Date** | {{ $subscription->ends_at->format('F j, Y') }} |

---

You now have full access to all features of your plan. Your subscription will remain active until **{{ $subscription->ends_at->format('F j, Y') }}**.

@component('mail::button', ['url' => config('app.url') . '/school/dashboard'])
Go to Dashboard
@endcomponent

---

*Thank you for choosing {{ config('app.name') }}! If you have any questions, feel free to reach out to our support team.*
@endcomponent
