<?php

namespace App\application\dtos;

class AuthorUseCaseAddInput
{
    public function __construct(
        public string $name,
        public string $sex,
        public string $cpf
    ){}
}