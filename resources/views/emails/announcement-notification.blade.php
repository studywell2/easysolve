@component('mail::message')
# New Announcement

**{{ $announcement->title }}**

{{ $announcement->body }}

@if($announcement->schoolClass)
This announcement is for: **{{ $announcement->schoolClass->name }}**
@else
This announcement is for: **Everyone**
@endif

@component('mail::button', ['url' => config('app.url') . '/dashboard'])
View Announcement
@endcomponent

---

*You received this email because you are registered at {{ $announcement->school->name }}.*
@if($announcement->creator)
Sent by {{ $announcement->creator->full_name }}
@endif
@endcomponent