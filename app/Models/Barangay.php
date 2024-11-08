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
        'email',
        'contact_number',
        'region_code',
        'province_code',
        'city_code',
        'barangay_code',
        'is_setup_complete',
        'address_line_one',
        'address_line_two'
    ];

    public function appearance_settings()
    {
        return $this->hasOne(AppearanceSetting::class, 'barangay_id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'barangay_feature_settings')
                    ->withPivot('is_enabled')
                    ->withTimestamps();
    }

    public function captain()
    {
        return $this->hasOne(Staff::class)
                ->where('is_master', true)
                ->where('barangay_id', $this->id);
    }     
}
