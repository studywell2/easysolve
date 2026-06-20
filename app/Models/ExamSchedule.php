<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'subject_id',
        'date',
        'start_time',
        'end_time',
        'room',
        'total_marks',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'total_marks' => 'decimal:2',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // ─── Helpers ──────────────────────────────────────

    public function getFormattedTimeAttribute(): string
    {
        return $this->start_time->format('g:i A') . ' – ' . $this->end_time->format('g:i A');
    }
}
