<?php

namespace App\web\request;

use App\infrastructure\database\contracts\DatabaseHandleExceptionInterface;
use App\infrastructure\database\contracts\DatabaseHandleOnSuccessInterface;
use App\infrastructure\database\contracts\DatabaseHandleStartStatementInterface;
use App\infrastructure\log\LogHandleExceptionInterface;
use Throwable;

readonly class RequestStatementExecute
{
    public function __construct(
        private LogHandleExceptionInterface           $logHandleException,
        private DatabaseHandleExceptionInterface      $databaseHandleException,
        private DatabaseHandleOnSuccessInterface       $databaseHandleOnSuccess,
        private DatabaseHandleStartStatementInterface $databaseHandleStartStatement
    ){}

    public function start():void
    {
        try{
            $this->databaseHandleStartStatement->start();

            $networkResponse = RequestExecute::execute();
            if($networkResponse->success){
                $this->databaseHandleOnSuccess->execute();
            }

            RequestSendResponse::execute($networkResponse);
        }catch (Throwable $throwable){
            $this->logHandleException->execute($throwable);
            $this->databaseHandleException->execute();
            RequestStatementException::execute();
        }
    }

}