<?php

namespace App\Models;

use App\Traits\HasPrettyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use HasFactory, SoftDeletes, HasPrettyStatus;

    protected $fillable = [
        'event_id',
        'user_id',
        'user_type',
        'time_in',
        'time_out',
        'is_present',
    ];

    public const STATUS_NONE = 0;

    public const STATUS_LOGIN_ONLY = 1;

    public const STATUS_PRESENT = 2;

    public const STATUS_ABSENT = 3;

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getParticipantIdNumber()
    {
        if ($this->user_type == 2) {
            return Student::find($this->user_id)->id_number;
        }

        return Faculty::find($this->user_id)->employee_id;
    }

    public function getParticipantName()
    {
        if ($this->user_type == 2) {
            return Student::find($this->user_id)->name;
        }

        return Faculty::find($this->user_id)->name;
    }

    public function getParticipantDepartment()
    {
        if ($this->user_type == 2) {
            return Student::find($this->user_id)->department;
        }

        return Faculty::find($this->user_id)->department;
    }

    public function getPrettyUserType()
    {
        if ($this->user_type == 2) {
            return 'Student';
        }

        return 'Faculty';
    }
}
