<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturePermission extends Model
{
    protected $fillable = ['feature_id', 'permissible_id', 'permissible_type', 'role', 'can_view', 'can_edit'];

    /**
     * Polymorphic relationship to permissible (Staff, Official, etc.).
     */
    public function permissible()
    {
        return $this->morphTo();
    }

    /**
     * Relationship to the feature.
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}


