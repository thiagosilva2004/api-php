<?php

namespace App\application\dtos;

use App\domain\entities\Author;
use App\presentation\languages\LanguageItems;

class AuthorUseCaseGetAllOutput
{

    /**
     * @param array<LanguageItems> $errors
     * @param array<Author> $authors
     */
    public function __construct(
        public array $errors,
        public array $authors
    ){}
}