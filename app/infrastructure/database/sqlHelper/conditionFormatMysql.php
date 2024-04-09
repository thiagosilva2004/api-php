<?php

namespace App\infrastructure\database\sqlHelper;

use App\infrastructure\database\types\DatabaseParamsSelect;

/**
 * @param array<DatabaseParamsSelect> $params
 * @return string
 */
function conditionFormatMysql(array $params):string
{
    $where = '';
    if(count($params) == 0){
        return $where;
    }
    $where = ' WHERE ';

    for ($i = 0; $i < count($params); $i++) {
        $where .= $i == 0 ? conditionFormatDataMysql($params[$i]) : ' AND ' . conditionFormatDataMysql($params[$i]);
    }
    return $where;
}