<?php

namespace App\domain\valueObjects;

use App\domain\exception\ExceptionSexInvalid;
use App\domain\exception\ExceptionSexNotImplemented;

enum Sex
{
    case MAN;
    case WOMAN;
    case UNKNOWN;
    
    public function toString():string
    {
        return match($this) {
            self::MAN => "M",
            self::WOMAN => "W",
            self::UNKNOWN => "U"
        };
    }

    public static function stringToSex(string $sex):Sex|false
    {
        return match (strtoupper($sex)){
            "M", "MAN" => self::MAN,
            "W", "WOMAN" => self::WOMAN,
            "U", "UNKNOWN" => self::UNKNOWN,
            default => false
        };
    }
}