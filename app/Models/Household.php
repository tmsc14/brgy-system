<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'household_head_user_id',
        'street_address',
        'purok',
        'sitio'
    ];

    protected $table = "household";

    public function user()
    {
        return $this->belongsTo(User::class, 'household_head_user_id');
    }

    public function residents()
    {
        return $this->hasMany(Resident::class, 'household_id');
    }
}
