<?php

namespace App\presentation\controller\request;

class AuthorAddRequest
{
    public function __construct(
        public ?string $name,
        public ?string $cpf,
        public ?string $sex
    ){}
}