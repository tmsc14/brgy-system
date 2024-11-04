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

    public static function getLastFiveDays()
    {
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $lastFiveDays = [];

        for ($i = 4; $i >= 0; $i--)
        {
            $date = new DateTime();
            $date->modify("-{$i} day");

            $day = $date->format('j'); // Day of the month without leading zeros
            $weekday = $daysOfWeek[$date->format('w')]; // Day of the week

            $lastFiveDays[$date->format("m-d")] = "{$day} {$weekday}";
        }

        return $lastFiveDays;
    }
}
