<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class BarangayCaptain extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'region',
        'province',
        'city_municipality',
        'barangay',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'email',
        'contact_no',
        'bric',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function barangay()
    {
        return $this->hasOne(Barangay::class, 'barangay_captain_id', 'id');
    }
}