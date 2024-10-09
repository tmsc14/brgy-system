<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'barangay';

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description',
        'email',
        'contact_number',
        'region_code',
        'province_code',
        'city_code'
    ];

    public function appearanceSettings()
    {
        return $this->hasOne(AppearanceSetting::class, 'barangay_id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'barangay_feature_settings')
                    ->withPivot('is_enabled')
                    ->withTimestamps();
    }     
}
