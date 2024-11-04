<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    use HasFactory;

    const DEFAULT_THEME_COLOR = '#FAEED8';
    const DEFAULT_PRIMARY_COLOR = '#503C2F';
    const DEFAULT_SECONDARY_COLOR = '#FAFAFA';
    const DEFAULT_TEXT_COLOR = '#000000';
    const DEFAULT_CONTENT_COLOR = '#B6977D';

    protected $table = 'appearance_settings';

    protected $fillable = [
        'barangay_id',
        'theme_color',
        'primary_color',
        'secondary_color',
        'text_color',
        'logo_path',
        'content_color'
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}
