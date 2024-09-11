<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_captain_id',
        'barangay_name',
        'barangay_email',
        'barangay_office_address',
        'barangay_complete_address_1',
        'barangay_complete_address_2',
        'barangay_description',
        'barangay_contact_number',
        'region',
        'province',
        'city',
        'barangay',
    ];

    public function barangayCaptain()
    {
        return $this->belongsTo(BarangayCaptain::class);
    }

    public function appearanceSettings()
    {
        return $this->hasOne(AppearanceSetting::class, 'barangay_captain_id', 'barangay_captain_id');
    }

    public function officials()
    {
        return $this->hasMany(BarangayOfficial::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'barangay_feature_settings')
                    ->withPivot('is_enabled')
                    ->withTimestamps();
    }     
}
