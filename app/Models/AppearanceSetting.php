<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    use HasFactory;

    protected $table = 'appearance_settings';

    protected $fillable = [
        'barangay_id',
        'theme_color',
        'primary_color',
        'secondary_color',
        'text_color',
        'logo_path',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}