<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Removed as it will be handled by the polymorphic relation
        'user_type', // The model type
        'barangay_id',
        'role_type',
        'active',
    ];

    // Define the polymorphic relationship
    public function user()
    {
        return $this->morphTo();
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}
