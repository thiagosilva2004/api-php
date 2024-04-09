<?php

namespace App\infrastructure\database\implemention;

use App\infrastructure\database\contracts\DatabaseContextInterface;
use App\infrastructure\database\contracts\DatabaseHandleStartStatementInterface;

class DatabaseHandleStartStatement implements DatabaseHandleStartStatementInterface
{
    public function __construct(
        private readonly DatabaseContextInterface $databaseContext
    ){}
    public function start(): void
    {
        $this->databaseContext->startStatement();
    }
}