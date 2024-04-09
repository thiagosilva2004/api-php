<?php

namespace App\infrastructure\log;

use Throwable;

class LogHandleException implements LogHandleExceptionInterface
{

    public function __construct(private readonly LogInterface $log){}

    public function execute(Throwable $throwable): void
    {
        $this->log->setExcecao($throwable->getMessage() . ':' . $throwable->getTraceAsString());
        $this->log->setLocal('File: ' . $throwable->getFile() . ' Line: ' . $throwable->getLine());
        $this->log->setMensagem('Code:' . $throwable->getCode());

        $this->log->gravarLog();
    }
}