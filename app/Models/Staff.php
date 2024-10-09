<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;

class Staff extends Authenticatable
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'barangay_id',
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'email',
        'contact_number',
        'date_of_birth',
        'bric_number',
        'is_master',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id');
    }

    public function featurePermissions()
    {
        return $this->morphMany(FeaturePermission::class, 'permissible');
    }    
}
