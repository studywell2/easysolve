<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'body',
        'audience',
        'class_id',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

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

    // ─── Scopes ────────────────────────────────────────

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    /**
     * Filter announcements visible to a given user based on their role.
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

            // Class-specific announcements
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
}
