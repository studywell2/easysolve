<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'email',
        'phone',
        'address',
        'motto',
        'terms_and_conditions',
        'terms_updated_at',
        'subscription_status',
        'trial_ends_at',
        'owner_id',
        'plan_id',
    ];

    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
            'terms_updated_at' => 'datetime',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function academicSessions()
    {
        return $this->hasMany(AcademicSession::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function staffAttendances()
    {
        return $this->hasMany(StaffAttendance::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function paymentRequests()
    {
        return $this->hasMany(PaymentRequest::class);
    }

    public function libraryBooks()
    {
        return $this->hasMany(LibraryBook::class);
    }

    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }

    public function homework()
    {
        return $this->hasMany(Homework::class);
    }

    public function events()
    {
        return $this->hasMany(SchoolEvent::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->whereNotIn('status', ['canceled', 'expired'])
            ->latest();
    }

    // ─── Subscription Helpers ──────────────────────────

    public function isOnTrial(): bool
    {
        return $this->subscription_status === 'trial'
            && $this->trial_ends_at
            && $this->trial_ends_at->isFuture();
    }

    public function trialDaysLeft(): int
    {
        if (! $this->trial_ends_at) {
            return 0;
        }

        return max(0, now()->startOfDay()->diffInDays($this->trial_ends_at->startOfDay()));
    }

    public function hasActiveSubscription(): bool
    {
        if ($this->subscription_status !== 'active') {
            return false;
        }

        // If a subscription record exists, verify it hasn't expired
        $subscription = $this->subscriptions()
            ->where('status', 'active')
            ->latest('ends_at')
            ->first();

        if (! $subscription) {
            return true; // No subscription record — trust the denormalized status
        }

        return $subscription->ends_at && $subscription->ends_at->isFuture();
    }

    public function getCurrentTermAttribute(): ?Term
    {
        return Term::whereHas('academicSession', fn ($q) => $q->where('school_id', $this->id))
            ->where('is_current', true)
            ->first();
    }
}
