<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'event_participant_id', 'user_id', 'user_type',
        'type', 'title', 'message', 'read_at',
    ];

    protected $casts = ['read_at' => 'datetime'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function eventParticipant(): BelongsTo
    {
        return $this->belongsTo(EventParticipant::class);
    }

    public function scopeForUser($query, $userId, $userType)
    {
        return $query->where('user_id', $userId)->where('user_type', $userType);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
