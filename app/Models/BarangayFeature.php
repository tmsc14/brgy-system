<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangayFeature extends Model
{
    protected $fillable = 
    [
        'barangay_id', 
        'category', 
        'name',
        'description',
        'is_enabled',
    ];

    protected $table = 'barangay_feature';
}
