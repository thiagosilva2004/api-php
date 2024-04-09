<?php

namespace App\infrastructure\database\implemention;

use App\infrastructure\database\contracts\DatabaseContextInterface;
use App\infrastructure\database\contracts\DatabaseHandleExceptionInterface;

readonly class DatabaseHandleException implements DatabaseHandleExceptionInterface
{

    public function __construct(
        private DatabaseContextInterface $databaseContext
    )
    {}

    public function execute(): void
    {
        $this->databaseContext->rollback();
    }
}