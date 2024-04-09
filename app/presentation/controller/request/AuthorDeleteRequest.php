<?php

namespace App\presentation\controller\request;

class AuthorDeleteRequest
{
    public function __construct(
        public ?int $author_id,
    ){}
}