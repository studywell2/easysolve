<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'user_id',
        'date',
        'clock_in_at',
        'clock_out_at',
        'notes',
        'clock_in_ip',
        'clock_out_ip',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'clock_in_at' => 'datetime',
            'clock_out_at' => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ───────────────────────────────────────

    public function isClockedIn(): bool
    {
        return $this->clock_in_at !== null && $this->clock_out_at === null;
    }

    public function isClockedOut(): bool
    {
        return $this->clock_out_at !== null;
    }

    /**
     * Duration in minutes between clock-in and clock-out (or now if still clocked in).
     */
    public function getDurationMinutesAttribute(): ?float
    {
        if (! $this->clock_in_at) {
            return null;
        }

        $end = $this->clock_out_at ?? now();

        return $this->clock_in_at->diffInMinutes($end);
    }

    /**
     * Human-readable duration (e.g. "6h 30m").
     */
    public function getFormattedDurationAttribute(): string
    {
        $minutes = $this->duration_minutes;

        if ($minutes === null) {
            return '—';
        }

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}h {$mins}m";
        }

        return "{$mins}m";
    }

    public function getFormattedClockInAttribute(): string
    {
        return $this->clock_in_at?->format('g:i A') ?? '—';
    }

    public function getFormattedClockOutAttribute(): string
    {
        return $this->clock_out_at?->format('g:i A') ?? '—';
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('M d, Y');
    }
}
