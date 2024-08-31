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

    public function user()
    {
        return $this->belongsTo(BarangayCaptain::class, 'user_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}

