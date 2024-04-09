<?php

namespace App\application\dtos;

class AuthorUseCaseUpdateInput
{
    public function __construct(
        public int $author_id,
        public string $name,
        public string $sex
    ){}
}