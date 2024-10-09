<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'barangay_id',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')
            ->withPivot('barangay_id')
            ->wherePivot('barangay_id', $this->barangay_id);
    }
}
