<?php

namespace App\application\SearchOptions;

use App\application\dtos\AuthorUseCaseGetAllInput;

class AuthorSearchOptions
{
    public function __construct(
        public ?string $name,
    ){}

    public static function toSearchOptions(AuthorUseCaseGetAllInput $input): AuthorSearchOptions
    {
        return new AuthorSearchOptions($input->name);
    }
}