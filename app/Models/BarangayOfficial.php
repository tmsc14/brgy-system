<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BarangayOfficial extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'dob', 'gender',
        'email', 'contact_no',
        'bric_no', 'barangay_id',
        'password',
        'valid_id',
        'position',
        'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard = 'barangay_official';

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}
