<?php

namespace App\presentation\controller\request;

class AuthorPutRequest
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $cpf,
        public ?string $sex
    ){}
}