<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'barangay';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'email',
        'contact_number',
        'region_code',
        'province_code',
        'city_code',
        'barangay_code',
        'is_setup_complete',
        'barangay_office_address',
        'address_line_one',
        'address_line_two'
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
