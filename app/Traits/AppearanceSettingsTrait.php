<?php

namespace App\Traits;

trait AppearanceSettingsTrait
{
    public function getThemes()
    {
        return [
            'default' => [
                'theme_color' => '#FAEED8',
                'primary_color' => '#503C2F',
                'secondary_color' => '#FAFAFA',
                'text_color' => '#000000',
            ],
            'dark' => [
                'theme_color' => '#2E2E2E',
                'primary_color' => '#1A1A1A',
                'secondary_color' => '#FAFAFA',
                'text_color' => '#FFFFFF',
            ],
            'blue' => [
                'theme_color' => '#E3F2FD',
                'primary_color' => '#2196F3',
                'secondary_color' => '#BBDEFB',
                'text_color' => '#0D47A1',
            ],
            'green' => [
                'theme_color' => '#E8F5E9',
                'primary_color' => '#4CAF50',
                'secondary_color' => '#C8E6C9',
                'text_color' => '#1B5E20',
            ],
        ];
    }

    public function convertToHex($color)
    {
        if (strpos($color, '#') === 0) {
            return $color;
        }

        $rgb = sscanf($color, "rgb(%d, %d, %d)");
        if ($rgb) {
            return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
        }

        $hsl = sscanf($color, "hsl(%d, %d%%, %d%%)");
        if ($hsl) {
            return $this->hslToHex($hsl[0], $hsl[1], $hsl[2]);
        }

        return $color; // fallback if conversion fails
    }

    public function hslToHex($h, $s, $l)
    {
        $h /= 360;
        $s /= 100;
        $l /= 100;

        $r = $l;
        $g = $l;
        $b = $l;
        $v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
        if ($v > 0) {
            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6.0;
            $six = floor($h);
            $fract = $h - $six;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;
            switch ($six) {
                case 0:
                    $r = $v;
                    $g = $mid1;
                    $b = $m;
                    break;
                case 1:
                    $r = $mid2;
                    $g = $v;
                    $b = $m;
                    break;
                case 2:
                    $r = $m;
                    $g = $v;
                    $b = $mid1;
                    break;
                case 3:
                    $r = $m;
                    $g = $mid2;
                    $b = $v;
                    break;
                case 4:
                    $r = $mid1;
                    $g = $m;
                    $b = $v;
                    break;
                case 5:
                    $r = $v;
                    $g = $m;
                    $b = $mid2;
                    break;
            }
        }

        return sprintf("#%02x%02x%02x", round($r * 255.0), round($g * 255.0), round($b * 255.0));
    }
}
