<?php

namespace App\Traits;

use App\Classes\RGBColor;

trait AppearanceSettingsTrait
{
    public function getThemes()
    {
        return [
            'default' => [
                'theme_color' => '#FAEED8',
                'primary_color' => '#503C2F',
                'secondary_color' => '#FAFAFA',
                'content_color' => '#B6977D',
            ],
            'dark' => [
                'theme_color' => '#2E2E2E',
                'primary_color' => '#1A1A1A',
                'secondary_color' => '#FAFAFA',
                'content_color' => '#B6977D',
            ],
            'blue' => [
                'theme_color' => '#E3F2FD',
                'primary_color' => '#2196F3',
                'secondary_color' => '#BBDEFB',
                'content_color' => '#B6977D',
            ],
            'green' => [
                'theme_color' => '#E8F5E9',
                'primary_color' => '#4CAF50',
                'secondary_color' => '#C8E6C9',
                'content_color' => '#B6977D',
            ],
        ];
    }

    public function convertHexToRGB($hex)
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return $r . ', ' . $g . ', ' . $b;
    }
}
