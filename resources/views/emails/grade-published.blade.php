@component('mail::message')
# New Grade Published

A new grade has been recorded for **{{ $grade->student->full_name }}**.

| Detail | Score |
|--------|-------|
| **Subject** | {{ $grade->subject->name }} |
| **Term** | {{ $term->name }} ({{ $term->academicSession->name }}) |
| **CA Score** | {{ number_format($grade->ca_score, 2) }} / 40 |
| **Exam Score** | {{ number_format($grade->exam_score, 2) }} / 60 |
| **Total** | **{{ number_format($grade->total_score, 2) }} / 100** |
| **Grade** | **{{ $grade->grade }}** |

@if($grade->remarks)
**Remarks:** {{ $grade->remarks }}
@endif

@component('mail::button', ['url' => config('app.url') . '/dashboard'])
View Full Results
@endcomponent

---

*You received this email because grades were published at {{ $grade->school->name }}.*
@endcomponent