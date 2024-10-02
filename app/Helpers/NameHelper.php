<?php

namespace App\Helpers;

class NameHelper
{
    public static function getReadableName($firstName, $lastName)
    {
        return $firstName . " " . $lastName;
    }
}
