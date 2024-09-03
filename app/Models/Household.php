<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'bric_no',
        'gender',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
