<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'label', 'category'];

    public function barangays()
    {
        return $this->belongsToMany(Barangay::class, 'barangay_feature_settings')
                    ->withPivot('is_enabled')
                    ->withTimestamps();
    }    

    public function isEnabled($barangay)
    {
        $feature = $barangay->features()->where('feature_id', $this->id)->first();
        return $feature && $feature->pivot->value == 1;
    }

    public function barangayCaptains()
    {
        return $this->belongsToMany(BarangayCaptain::class, 'barangay_feature_settings')
                    ->withPivot('is_enabled')
                    ->withTimestamps();
    }

    public function permissions()
    {
        return $this->hasMany(FeaturePermission::class);
    }
}
