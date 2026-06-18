<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'subject',
        'created_by',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ─── Helpers ──────────────────────────────────────

    /**
     * The other participant in a 1-on-1 conversation.
     */
    public function otherParticipant(User $user)
    {
        return $this->participants()->where('user_id', '!=', $user->id)->first();
    }

    /**
     * Unread message count for a given user.
     */
    public function unreadCountFor(User $user): int
    {
        $pivot = $this->participants()->where('user_id', $user->id)->first()?->pivot;

        if (!$pivot || !$pivot->last_read_at) {
            return $this->messages()->where('sender_id', '!=', $user->id)->count();
        }

        return $this->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('created_at', '>', $pivot->last_read_at)
            ->count();
    }

    /**
     * Mark conversation as read for a given user.
     */
    public function markAsRead(User $user): void
    {
        $this->participants()->updateExistingPivot($user->id, [
            'last_read_at' => now(),
        ]);
    }
}
