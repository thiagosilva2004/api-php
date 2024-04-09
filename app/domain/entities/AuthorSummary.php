<?php

namespace App\domain\entities;

class AuthorSummary
{
    public function __construct(
        public int $id,
        public string $name
    ){}
}