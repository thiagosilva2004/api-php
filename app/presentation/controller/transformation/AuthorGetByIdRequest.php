<?php

namespace App\presentation\controller\transformation;

class AuthorGetByIdRequest
{
    public function __construct(
        public ?int $id,
    ){}
}