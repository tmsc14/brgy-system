<?php

namespace App\Helpers;

class NameHelper
{
    public static function getReadableName($firstName, $lastName, $middleName = '')
    {
        return $firstName . " " . $middleName . " " . $lastName;
    }
}
