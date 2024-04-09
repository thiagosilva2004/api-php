<?php

namespace App\infrastructure\database\sqlHelper;

use App\infrastructure\database\types\DatabaseParams;

/**
 * @param bool $isValueParam
 * @param array<DatabaseParams> $params
 * @return string
 */
function paramsFormatInsertMysql(bool $isValueParam, array $params):string
{
    $sql = '';
    if($isValueParam){
        $sql .= " VALUES ";
    }
    $sql .= "(";
    for ($i = 0; $i < count($params); $i++) {
        $param = $params[$i];
        if($isValueParam){
            $sql .= $i == count($params) - 1 ? " :$param->name " :  " :$param->name, ";
        }else{
            $sql .= $i == count($params) - 1 ? " $param->name " :  " $param->name, ";
        }
    }
    return  $sql . ") ";
}