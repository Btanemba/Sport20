<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{

    use HasFactory,CrudTrait;

    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
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

    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'street' => 'string',
        'number' => 'string',
        'city' => 'string',
        'zip' => 'string',
        'region' => 'string',
        'country' => 'string',
        'phone' => 'string',
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
