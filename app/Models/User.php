<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ADMIN = 1;

    public const STUDENT = 2;

    public const FACULTY = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'user_id',
        'account_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function scopeIsAdmin()
    {
        return $this->account_type == 1;
    }

    public function scopeIsStudent()
    {
        return $this->account_type == 2;
    }

    public function scopeIsFaculty()
    {
        return $this->account_type == 3;
    }

    public function getName()
    {
        if ($this->account_type == 1) {
            return Admin::find($this->user_id)->name;
        } elseif ($this->account_type == 2) {
            return Student::find($this->user_id)->name;
        }

        return Faculty::find($this->user_id)->name;
    }

    public function getUser()
    {
        if ($this->account_type == 1) {
            return Admin::find($this->user_id);
        } elseif ($this->account_type == 2) {
            return Student::find($this->user_id);
        }

        return Faculty::find($this->user_id);
    }
}
