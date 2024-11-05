<?php

namespace App\Helpers;

use App\Classes\RGBColor;

class ThemeHelper
{
    public static function setSessionAppearanceSettings($appearanceSettings)
    {
        $primaryColor = RGBColor::fromString($appearanceSettings->primary_color);
        $secondaryColor = RGBColor::fromString($appearanceSettings->secondary_color);
        $backgroundColor = RGBColor::fromString($appearanceSettings->theme_color);

        session([
            // Base
            'primary_color' => RGBColor::fromString($appearanceSettings->primary_color)->toString(),
            'primary_color_bright' => self::getUserHeaderColor(RGBColor::fromString($appearanceSettings->primary_color))->toString(),
            'background_color' => $backgroundColor->toString(),
            'secondary_color' => $secondaryColor->toString(),
            'content_color' => RGBColor::fromString($appearanceSettings->content_color)->toString(),
            // Base hover
            'primary_hover_color' => self::getHoverColor(RGBColor::fromString($appearanceSettings->primary_color))->toString(),
            'secondary_hover_color' => self::getHoverColor(RGBColor::fromString($appearanceSettings->secondary_color))->toString(),
            // Text
            'primary_text_color' => self::getReadableTextColor(RGBColor::fromString($appearanceSettings->primary_color))->toString(),
            'highlighted_text_color' => self::getReadableTextColor(RGBColor::fromString($appearanceSettings->secondary_color))->toString(),
            'content_text_color' => self::getReadableTextColor(RGBColor::fromString($appearanceSettings->content_color))->toString(),
            // Text hover
            'primary_text_hover_color' => self::getTextHoverColor(self::getReadableTextColor(RGBColor::fromString($appearanceSettings->primary_color)))->toString(),
    ]);
    }

    public static function getReadableTextColor(RGBColor $color)
    {
        return $color->getPerceivedBrightness() >= 125
            ? RGBColor::black()
            : RGBColor::white();
    }

    public static function getHoverColor(RGBColor $color)
    {
        return $color->getLightness() > .4
            ? $color->darken(5)
            : $color->brighten(5);
    }

    public static function getTextHoverColor(RGBColor $color)
    {
        return $color->getLightness() > .4
            ? $color->darken(10)
            : $color->brighten(10);
    }

    public static function getUserHeaderColor(RGBColor $color)
    {
        return $color->brighten(10);
    }

    public static function convertHexToRGB($hex)
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return $r . ', ' . $g . ', ' . $b;
    }
}
