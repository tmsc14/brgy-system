<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasFactory;

    protected $table = 'barangay_staff';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'gender',
        'email',
        'contact_no',
        'barangay_id',
        'password',
        'valid_id',
        'position',
        'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard = 'barangay_staff';

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id');
    }
    
    public function activeRole()
    {
        return $this->hasOne(Role::class, 'user_id')->where('active', true);
    }    
}
