<?php

namespace App\infrastructure\database\sqlHelper;

use App\infrastructure\database\types\DatabaseParamsSelect;
use App\infrastructure\database\types\DatabaseParamsSelectType;
use Exception;

function conditionFormatDataMysql(DatabaseParamsSelect $param):string
{
    return match ($param->type){
        DatabaseParamsSelectType::STRING_EQUALS => STRING_EQUALS_ParamsData($param->name,$param->value),
        DatabaseParamsSelectType::EQUALS => EQUALS_ParamsData($param->name,$param->value),
      default => new Exception("DatabaseParamsSelect data not implemented")
    };
}

function STRING_EQUALS_ParamsData(string $name,string $value):string
{
    return "$name = :$name";
}

function EQUALS_ParamsData(string $name,mixed $value):string
{
    return "$name = :$name";
}
