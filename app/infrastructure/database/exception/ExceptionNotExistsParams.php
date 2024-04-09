<?php

namespace App\infrastructure\database\exception;

use Exception;

class ExceptionNotExistsParams extends Exception
{

    public function __construct(
        string                  $message,
        int                     $code = 0,
        Exception               $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString(): string
    {
        return __CLASS__ .
            ": [{$this->code}]: {$this->message}\n ";
    }
}