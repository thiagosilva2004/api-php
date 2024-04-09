<?php

namespace App\infrastructure\database\sqlHelper;

use App\infrastructure\database\types\DatabaseParams;

/**
 * @param array<DatabaseParams> $params
 * @return string
 */
function paramsFormatUpdateMysql(array $params):string
{
    $sql = " SET ";
    for ($i = 0; $i < count($params); $i++) {
        $param = $params[$i];
        $sql .= $i == count($params) - 1 ? " $param->name = :$param->name " :  " $param->name = :$param->name, ";
    }
    return $sql;
}