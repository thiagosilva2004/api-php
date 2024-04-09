<?php

namespace App\infrastructure\database\implemention;

use App\infrastructure\database\contracts\DatabaseContextInterface;
use App\infrastructure\database\contracts\DatabaseHandleOnSuccessInterface;

class DatabaseHandleOnSucesss implements DatabaseHandleOnSuccessInterface
{
    public function __construct(
        private DatabaseContextInterface $databaseContext
    ){}
    public function execute(): void
    {
        $this->databaseContext->commit();
    }
}