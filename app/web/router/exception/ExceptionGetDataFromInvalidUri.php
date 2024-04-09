<?php

namespace App\web\router\exception;

use Exception;

class ExceptionGetDataFromInvalidUri extends Exception
{

    public function __construct(
        private readonly string $uriActual,
        private readonly string $uriCompareInvalid,
        string                  $message,
        int                     $code = 0,
        Exception               $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return __CLASS__ .
               ": [{$this->code}]: {$this->message}\n 
               uriActual: $this->uriActual, uriCompareInvalid: $this->uriCompareInvalid \n";
    }
}