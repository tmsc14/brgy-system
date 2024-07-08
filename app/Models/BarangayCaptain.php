<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BarangayCaptain extends Authenticatable
{
    use HasFactory;

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
}


