<?php

namespace tests\fake;

class SexFaker
{
    private static array $listSexValid = array('M','Man','W');
    private static array $listSexInvalid = array('re','mfd','wq');

    public static function getSexValid():string
    {
        return self::$listSexValid[random_int(0,count(self::$listSexValid) - 1)];
    }

    public static function getSexInvalid():string
    {
        return self::$listSexInvalid[random_int(0,count(self::$listSexInvalid) - 1)];
    }
}