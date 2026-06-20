<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeworkSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'student_id',
        'content',
        'file_path',
        'submitted_at',
        'status',
        'score',
        'feedback',
        'graded_by',
        'graded_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'graded_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    // ─── Helpers ──────────────────────────────────────

    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }

    public function isSubmitted(): bool
    {
        return in_array($this->status, ['submitted', 'graded']);
    }
}
