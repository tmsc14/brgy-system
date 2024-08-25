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
        'dob',
        'gender',
        'email',
        'contact_no',
        'bric_no',
        'barangay_id',
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

