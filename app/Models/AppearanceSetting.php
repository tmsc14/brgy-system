<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_captain_id',
        'theme_color',
        'primary_color',
        'secondary_color',
        'text_color',
        'logo_path',
    ];

    public function barangayCaptain()
    {
        return $this->belongsTo(BarangayCaptain::class);
    }
}
