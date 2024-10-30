<?php

namespace App\Classes;

class RGBColor
{
    const MAX_VALUE = 250;
    const MIN_VALUE = 15;

    public $r;
    public $g;
    public $b;
    public $a;

    public function __construct($r, $g, $b, $a = 1.0)
    {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->a = $a;
    }

    public static function fromString($rgbString, $allowMaxValues = false)
    {
        $values = array_map('trim', explode(',', $rgbString));

        if (count($values) !== 3)
        {
            throw new InvalidArgumentException('Invalid RGB string format. Expected "R, G, B".');
        }

        $r = (int) $values[0];
        $g = (int) $values[1];
        $b = (int) $values[2];

        if (!$allowMaxValues)
        {
            if ($r <=17 && $g <= 12 && $b <= 12)
            {
                $r = self::MIN_VALUE;
                $g = self::MIN_VALUE;
                $b = self::MIN_VALUE;
            }
            else if ($r == 255 && $g >= 245 && $b >= 244)
            {
                $r = self::MAX_VALUE;
                $g = self::MAX_VALUE;
                $b = self::MAX_VALUE;
            }
        }

        return new self($r, $g, $b);
    }

    public static function white($max = false, $a = .9)
    {
        $value = $max ? 255 : self::MAX_VALUE;
        return new RGBColor($value, $value, $value, $a);
    }

    public static function black($max = false, $a = .9)
    {
        $value = $max ? 0 : self::MIN_VALUE;
        return new RGBColor($value, $value, $value, $a);
    }

    public function getPerceivedBrightness()
    {
        $brightness = 0.299 * $this->r + 0.587 * $this->g + 0.114 * $this->b;
        error_log("Brightness: " . $brightness);
        return $brightness;
    }

    public function getLightness()
    {
        $lightness = (max($this->r, $this->g, $this->b) + min($this->r, $this->g, $this->b)) / 510.0;
        error_log("Lightness: " . $lightness);
        return (max($this->r, $this->g, $this->b) + min($this->r, $this->g, $this->b)) / 510.0;
    }

    public function brighten($percent)
    {
        $this->r = min(255, $this->r + $this->r * ($percent / 100));
        $this->g = min(255, $this->g + $this->g * ($percent / 100));
        $this->b = min(255, $this->b + $this->b * ($percent / 100));

        return $this;
    }

    public function darken($percent)
    {
        $this->r = max(0, $this->r - $this->r * ($percent / 100));
        $this->g = max(0, $this->g - $this->g * ($percent / 100));
        $this->b = max(0, $this->b - $this->b * ($percent / 100));

        return $this;
    }

    public function toHex()
    {
        // Ensure RGB values are within 0-255
        $r = max(0, min(255, $this->r));
        $g = max(0, min(255, $this->g));
        $b = max(0, min(255, $this->b));

        // Convert to hexadecimal and format to 6 characters
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    public function mixWith(RGBColor $color)
    {
        $finalR = $this->r * $this->a * (1 - $color->a) + $color->r * $color->a;
        $finalG = $this->g * $this->a * (1 - $color->a) + $color->g * $color->a;
        $finalB = $this->b * $this->a * (1 - $color->a) + $color->b * $color->a;

        $finalA = $this->a * (1 - $color->a) + $color->a;

        error_log($this->toString());
        error_log($color->toString());
        error_log("Color: " . $finalR . ', ' . $finalG . ', ' . $finalB );
        return new RGBColor($finalR, $finalG, $finalB, $finalA);
    }

    public function toString()
    {
        return "rgba(" . round($this->r) . ", " . round($this->g) . ", " . round($this->b) . ", " . $this->a . ")";
    }
}
