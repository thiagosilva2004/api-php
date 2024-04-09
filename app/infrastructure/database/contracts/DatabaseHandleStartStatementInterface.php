<?php

namespace App\infrastructure\database\contracts;

interface DatabaseHandleStartStatementInterface
{
    public function start():void;
    
}