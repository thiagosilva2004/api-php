<?php

namespace App\presentation\controller\request;

class AuthorGetAllRequst
{
    public function __construct(
        public ?string $name
    ){}
}