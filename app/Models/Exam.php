<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'term_id',
        'class_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }

    // ─── Scopes ───────────────────────────────────────

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // ─── Helpers ──────────────────────────────────────

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function getFormattedDateAttribute(): string
    {
        if ($this->end_date && $this->end_date != $this->start_date) {
            return $this->start_date->format('M j') . ' – ' . $this->end_date->format('M j, Y');
        }
        return $this->start_date->format('M j, Y');
    }
}
