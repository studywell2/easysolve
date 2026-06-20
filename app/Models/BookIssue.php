<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookIssue extends Model
{
    use HasFactory;

    protected $table = 'book_issues';

    protected $fillable = [
        'school_id',
        'library_book_id',
        'user_id',
        'issue_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function book()
    {
        return $this->belongsTo(LibraryBook::class, 'library_book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'issued')->where('due_date', '<', now()->toDateString());
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'issued' && $this->due_date < now()->toDateString();
    }
}
