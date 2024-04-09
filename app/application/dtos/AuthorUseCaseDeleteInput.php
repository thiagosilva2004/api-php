<?php

namespace App\application\dtos;

class AuthorUseCaseDeleteInput
{
    public function __construct(
        public ?int $author_id,
    ){}
}