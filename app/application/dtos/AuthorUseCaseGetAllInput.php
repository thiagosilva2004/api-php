<?php

namespace App\application\dtos;

class AuthorUseCaseGetAllInput
{
    public function __construct
    (
        public ?string $name,
    ){}
}