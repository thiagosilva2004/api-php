<?php

namespace App\application\abstractions;

interface CacheDatasInterface
{
    public function get():array;
    public function save(array $datas):void;
}