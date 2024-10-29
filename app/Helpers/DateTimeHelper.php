<?php

namespace App\Helpers;

use DateTime;

class DateTimeHelper
{
    public static function getDayWithSuffix($day)
    {
        $suffix = match ($day)
        {
            1, 21, 31 => 'st',
            2, 22 => 'nd',
            3, 23 => 'rd',
            default => 'th',
        };

        return $day . $suffix;
    }

    public static function getAgeByDate($date)
    {
        $dateCreated = new DateTime($date);
        $now = new DateTime();
        return $now->diff($dateCreated)->y;
    }
}
