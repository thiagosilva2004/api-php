<?php

namespace App\infrastructure\database\types;

use Exception;
use PDO;

class DatabaseParamsTypeToPdo
{

    public static function convert(DatabaseParamsType $type):int
    {
        return match ($type){
          DatabaseParamsType::STRING => PDO::PARAM_STR,
            DatabaseParamsType::INTEGER => PDO::PARAM_INT,
            default => throw new Exception("Type unknown in pdo")
        };
    }
}