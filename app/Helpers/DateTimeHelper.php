<?php

namespace App\Helpers;

class DateTimeHelper
{
    public static function getDayWithSuffix($day)
    {
        // Determine the suffix
        $suffix = match ($day)
        {
            1, 21, 31 => 'st',
            2, 22 => 'nd',
            3, 23 => 'rd',
            default => 'th',
        };

        return $day . $suffix;
    }
}
