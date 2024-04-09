<?php

namespace App\application\dtos;

use App\domain\entities\Author;
use App\presentation\languages\LanguageItems;

class AuthorUseCaseGetByIdOutput
{
    /**
     * @param array<LanguageItems> $errors
     */
    public function __construct(
        public array $errors,
        public ?Author $authors
    ){}
}