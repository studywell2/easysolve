<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homework';

    protected $fillable = [
        'school_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'term_id',
        'title',
        'description',
        'due_date',
        'max_score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'max_score' => 'decimal:2',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function submissions()
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    // ─── Scopes ───────────────────────────────────────

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // ─── Helpers ──────────────────────────────────────

    public function isOverdue(): bool
    {
        return $this->due_date->isPast();
    }

    public function submissionFor(User $student): ?HomeworkSubmission
    {
        return $this->submissions()->where('student_id', $student->id)->first();
    }
}
