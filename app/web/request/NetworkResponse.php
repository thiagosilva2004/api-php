<?php

namespace App\web\request;
use App\presentation\languages\LanguageItems;

final class NetworkResponse
{
        public function __construct(
            public int                  $code = 200,
            public string|LanguageItems $message = "",
            public array                $data = [],
            public bool                 $success = false
        ){}
}