<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barangay_id',
        'role_type',
        'active',
    ];

    // Define the relationship based on role_type
    public function user()
    {
        switch ($this->role_type) {
            case 'barangay_official':
                return $this->belongsTo(BarangayOfficial::class, 'user_id');
            case 'barangay_staff':
                return $this->belongsTo(Staff::class, 'user_id');
            case 'barangay_captain':
                return $this->belongsTo(BarangayCaptain::class, 'user_id');
            default:
                return null;
        }
    }    

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}

