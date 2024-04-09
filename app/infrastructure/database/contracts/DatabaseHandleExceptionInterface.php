<?php

namespace App\infrastructure\database\contracts;

interface DatabaseHandleExceptionInterface
{
    public function execute():void;
}