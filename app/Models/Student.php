<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id_number'];

    protected $fillable = [
        'id_number',
        'name',
        'department',
        'year_level',
        'section',
        'contact_number',
        'email',
    ];

    public function eventParticipants()
    {
        return $this->belongsTo(EventParticipant::class, 'user_id', 'id');
    }
}
