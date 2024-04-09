<?php

namespace App\application\dtos;

class AuthorUseCaseDeleteOutput
{
    public function __construct(
        public array $errors,
    ){}
}