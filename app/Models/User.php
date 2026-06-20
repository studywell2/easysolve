<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected $fillable = [
        'school_id',
        'parent_id',
        'class_id',
        'section_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'is_active',
        'last_seen',
        'terms_accepted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_seen' => 'datetime',
            'terms_accepted_at' => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function staffAttendances()
    {
        return $this->hasMany(StaffAttendance::class);
    }

    public function todayStaffAttendance()
    {
        return $this->hasOne(StaffAttendance::class)
            ->where('date', today())
            ->latest();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id')
            ->withTimestamps();
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function bookIssues()
    {
        return $this->hasMany(BookIssue::class);
    }

    // ─── Role Checks ──────────────────────────────────

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    /** Can access the school portal (owner, admin, teacher) */
    public function canManageSchool(): bool
    {
        return in_array($this->role, ['owner', 'admin', 'teacher']);
    }

    /** Whether the user has accepted the school's latest T&C */
    public function hasAcceptedLatestTerms(): bool
    {
        $school = $this->school;

        if (! $school || empty($school->terms_and_conditions)) {
            return true;
        }

        if ($this->terms_accepted_at === null) {
            return false;
        }

        if ($school->terms_updated_at && $school->terms_updated_at->gt($this->terms_accepted_at)) {
            return false;
        }

        return true;
    }

    // ─── Accessors ────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1).substr($this->last_name, 0, 1));
    }
}
