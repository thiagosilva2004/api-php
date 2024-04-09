<?php

namespace App\infrastructure\database\contracts;

interface DatabaseHandleOnSuccessInterface
{
    public function execute():void;
}