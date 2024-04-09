<?php

namespace App\application\contracts;

use App\application\SearchOptions\AuthorSearchOptions;
use App\domain\entities\Author;
use App\domain\valueObjects\CPF;

interface AuthorRepositoryInterface
{
    public function add(Author $author):int;
    public function getByID(int $id):?Author;
    public function getByCPF(CPF $CPF):?Author;

    /**
     * @param AuthorSearchOptions $authorSearchOptions
     * @return array<Author>
     */
    public function getAll(AuthorSearchOptions $authorSearchOptions):array;
    public function update(Author $author):bool;
    public function delete(int $id):bool;
    public function existWithID(int $author_id):bool;
    public function existWithCPF(CPF $CPF):bool;
}