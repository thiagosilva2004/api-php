<?php

namespace tests\fake;

class NameFaker
{
    private static array $listNameValid = array('Thiago Silva','Mauro Souza','Ana Maria de Oliveira');
    private static array $listNameInvalid = array('th','ma','a');

    public static function getNameValid():string
    {
        return self::$listNameValid[random_int(0,count(self::$listNameValid) - 1)];
    }

    public static function getNameInvalid():string
    {
        return self::$listNameInvalid[random_int(0,count(self::$listNameInvalid) - 1)];
    }
}