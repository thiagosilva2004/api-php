<?php

namespace tests\fake;

class CPFFaker
{
    private static array $listCPFValid = array('67600869292','16652573342','58917476694');
    private static array $listCPFInvalid = array('15445','15445445454545454554','12345678911');

    public static function getCPFValid():string
    {
        return self::$listCPFValid[random_int(0,count(self::$listCPFValid) - 1)];
    }

    public static function getCPFInvalid():string
    {
        return self::$listCPFInvalid[random_int(0,count(self::$listCPFInvalid) - 1)];
    }
}