<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use CrudTrait, HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'email',
        'password',
        'active',
        // 'last_access'
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
            'active' => 'boolean', // Ensure 'active' is treated as a boolean
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->created_by = Auth::id();
        });

        static::updating(function ($user) {
            $user->updated_by = Auth::id();
        });
    }

    public function person()
    {
        return $this->hasOne(Person::class);
    }
}
