<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolEvent extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'type',
        'audience',
        'class_id',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Scopes ───────────────────────────────────────

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', today())->orderBy('start_date');
    }

    /**
     * Filter events visible to a given user based on their role.
     */
    public function scopeVisibleTo($query, User $user)
    {
        $query->where('school_id', $user->school_id);

        if ($user->canManageSchool()) {
            return;
        }

        $query->where(function ($q) use ($user) {
            $q->where('audience', 'all');

            if ($user->isParent()) {
                $q->orWhere('audience', 'parents');
            }

            if ($user->isStudent()) {
                $q->orWhere('audience', 'students');
            }

            if ($user->isStudent() && $user->class_id) {
                $q->orWhere(function ($cq) use ($user) {
                    $cq->where('audience', 'class')->where('class_id', $user->class_id);
                });
            }

            if ($user->isParent()) {
                $childrenClassIds = $user->children()->pluck('class_id')->filter();
                if ($childrenClassIds->isNotEmpty()) {
                    $q->orWhere(function ($cq) use ($childrenClassIds) {
                        $cq->where('audience', 'class')->whereIn('class_id', $childrenClassIds);
                    });
                }
            }
        });
    }

    // ─── Helpers ──────────────────────────────────────

    public static function types(): array
    {
        return [
            'exam' => 'Examination',
            'holiday' => 'Holiday',
            'ptc' => 'Parent-Teacher Conference',
            'sports' => 'Sports Event',
            'meeting' => 'Meeting',
            'other' => 'Other',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::types()[$this->type] ?? ucfirst($this->type);
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'exam' => 'bg-red-100 text-red-700 border-red-200',
            'holiday' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'ptc' => 'bg-purple-100 text-purple-700 border-purple-200',
            'sports' => 'bg-amber-100 text-amber-700 border-amber-200',
            'meeting' => 'bg-blue-100 text-blue-700 border-blue-200',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function getFormattedDateAttribute(): string
    {
        if ($this->end_date && $this->end_date != $this->start_date) {
            return $this->start_date->format('M j') . ' – ' . $this->end_date->format('M j, Y');
        }
        return $this->start_date->format('M j, Y');
    }

    public function getFormattedTimeAttribute(): ?string
    {
        if (!$this->start_time) {
            return null;
        }
        $time = $this->start_time->format('g:i A');
        if ($this->end_time) {
            $time .= ' – ' . $this->end_time->format('g:i A');
        }
        return $time;
    }
}
