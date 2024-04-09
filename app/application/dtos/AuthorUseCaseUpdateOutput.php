<?php

namespace App\application\dtos;

class AuthorUseCaseUpdateOutput
{
    public function __construct(
        public array $errors,
    ){}
}