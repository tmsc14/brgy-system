<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resident extends Authenticatable
{
    use HasFactory;

    protected $table = 'resident';

    protected $fillable = [
        'barangay_id',
        'user_id',
        'household_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'email',
        'contact_number',
        'date_of_birth',
        'bric_number',
        'is_head_of_household',
        'relationship_to_head',
        'ethnicity',
        'religion',
        'civil_status',
        'valid_id',
        'is_temporary_resident',
        'is_pwd',
        'is_voter',
        'is_employed',
        'is_active'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function household()
    {
        return $this->belongsTo(Household::class, 'household_id');
    }
}
