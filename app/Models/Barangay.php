<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'office_address',
        'complete_address_1',
        'complete_address_2',
        'description',
        'contact_number',
        'barangay_captain_id',
    ];

    public function barangayCaptain()
    {
        return $this->belongsTo(BarangayCaptain::class);
    }
}

