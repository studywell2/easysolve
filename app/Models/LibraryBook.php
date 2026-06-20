<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibraryBook extends Model
{
    use HasFactory;

    protected $table = 'library_books';

    protected $fillable = [
        'school_id',
        'title',
        'author',
        'isbn',
        'category',
        'publisher',
        'edition',
        'quantity',
        'shelf_location',
        'description',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function issues()
    {
        return $this->hasMany(BookIssue::class, 'library_book_id');
    }

    public function activeIssues()
    {
        return $this->issues()->where('status', 'issued');
    }

    public function getAvailableCopiesAttribute(): int
    {
        return $this->quantity - $this->activeIssues()->count();
    }
}
