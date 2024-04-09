<?php

namespace App\infrastructure\database\sqlHelper;

/**
 * @param array<string> $columns
 * @return string
 */
function columnsFormatMysql(array $columns):string
{
    if(count($columns) == 0){
        return ' * ';
    }

    $sql = '';
    for($i=0;$i < count($columns); $i++){
        $sql .= $i == 0 ? " $columns[$i] " : " ,$columns[$i] ";
    }
    return $sql;
}