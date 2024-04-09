<?php

namespace App\infrastructure\log;

use Throwable;

interface LogHandleExceptionInterface
{
    public function execute(Throwable $throwable);
}