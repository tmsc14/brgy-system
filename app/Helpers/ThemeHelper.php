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
            'primary_color' => RGBColor::fromString($appearanceSettings->primary_color)->toString(),
            'primary_color_bright' => self::getUserHeaderColor($primaryColor)->toString(),
            'background_color' => $backgroundColor->toString(),
            'secondary_color' => $secondaryColor->toString(),
            'primary_text_color' => self::getReadableTextColor($primaryColor)->toString(),
            'highlighted_text_color' => self::getReadableTextColor($secondaryColor)->toString(),
            'primary_hover_color' =>  self::getHoverColor(self::getReadableTextColor($primaryColor))->toString()
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
            ? $color->darken(10)
            : $color->brighten(10);
    }

    public static function getUserHeaderColor(RGBColor $color)
    {
        return $color->brighten(10);
    }
}
