<?php

namespace App\application\dtos;

class AuthorUseCaseGetByIdInput
{
    public function __construct(
        public ?int $author_id
    ){}
}