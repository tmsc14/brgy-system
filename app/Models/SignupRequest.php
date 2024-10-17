<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'user_id',
        'dob',
        'gender',
        'email',
        'contact_no',
        'barangay_id',
        'street_purok_sitio',
        'house_number_building_name',
        'is_renter',
        'is_employed',
        'password',
        'valid_id',
        'user_type',
        'position',
        'status',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}

