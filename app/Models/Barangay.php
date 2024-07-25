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
}
