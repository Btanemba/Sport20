<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'street',
        'number',
        'city',
        'zip',
        'region',
        'country',
        'phone',
        'user_id',
        'created_by',
        'updated_by',
    ];

    // Set the user who created or updated the record
    protected static function booted()
    {
        static::creating(function ($person) {
            $person->created_by = Auth::id();
        });

        static::updating(function ($person) {
            $person->updated_by = Auth::id();
        });
    }

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
