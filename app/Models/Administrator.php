<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory, CrudTrait;

    protected $table = 'administrators';

    protected $fillable = [
        'id', // Same as Person ID
        'level',
        'remark',
        'created_by',
        'updated_by',
    ];

    public $incrementing = false; // Disable auto-incrementing, use Person ID

    protected static function booted()
    {
        static::creating(function ($admin) {
            $admin->created_by = backpack_user()->id;
        });

        static::updating(function ($admin) {
            $admin->updated_by = backpack_user()->id;
        });
    }

    // ✅ Relationship with Person (1-to-1)
    public function person()
    {
        return $this->belongsTo(Person::class, 'id', 'id');
    }

    // ✅ Relationship to the User who created this admin
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Relationship to the User who last updated this admin
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
