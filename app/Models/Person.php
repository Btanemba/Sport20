<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Person extends Model
{
    use HasFactory, CrudTrait;

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

    protected static function booted()
    {
        static::creating(function ($person) {
            $person->created_by = Auth::id();
        });

        static::updating(function ($person) {
            $person->updated_by = Auth::id();
        });
    }

    // ✅ Relationship to Administrator (1-to-1)
    public function administrator()
    {
        return $this->hasOne(Administrator::class, 'id', 'id');
    }
}
