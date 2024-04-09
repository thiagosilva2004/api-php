<?php

namespace App\application\dtos;

class AuthorUseCaseAddOutput
{
    /**
     * @param array $errors
     * @param int $author_id
     */
    public function __construct(
        public array $errors,
        public int $author_id
    )
    {}
}