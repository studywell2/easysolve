@component('mail::message')
# Welcome to {{ config('app.name') }}!

Hello **{{ $user->full_name }}**,

Your account has been created at **{{ $user->school->name }}**.

Here are your login details:

| Field | Value |
|-------|-------|
| **Login URL** | {{ config('app.url') . '/login' }} |
| **Email** | {{ $user->email }} |
| **Password** | {{ $password }} |
| **Role** | {{ ucfirst($user->role) }} |

@if($user->class_id)
**Class:** {{ $user->schoolClass?->name }}
@endif

@component('mail::button', ['url' => config('app.url') . '/login'])
Login Now
@endcomponent

**Important:** Please change your password after your first login for security.

---

*If you did not expect this email, please contact your school administrator.*
@endcomponent