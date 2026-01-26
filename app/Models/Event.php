<?php

namespace App\Models;

use App\Traits\HasPrettyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes, HasPrettyStatus;

    protected $fillable = [
        'title',
        'date',
        'time_start',
        'time_end',
        'description',
    ];

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}
