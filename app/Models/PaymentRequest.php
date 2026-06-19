<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'plan_id',
        'billing_cycle',
        'amount',
        'proof_of_payment',
        'notes',
        'status',
        'admin_notes',
        'verified_by',
        'verified_at',
        'subscription_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // ─── Helpers ───────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getFormattedAmountAttribute(): string
    {
        return config('platform.currency_symbol', '₦') . number_format((float) $this->amount);
    }
}
