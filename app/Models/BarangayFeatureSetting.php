<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangayFeatureSetting extends Model
{
    protected $fillable = ['barangay_id', 'feature_id', 'is_enabled'];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
