<?php

namespace App\infrastructure\database\contracts;

use App\application\SearchOptions\AuthorSearchOptions;
use App\domain\entities\Author;
use App\domain\valueObjects\CPF;

interface AuthorRepositoryHelperDatabaseInterface
{
    public function add(Author $author):int;
    public function getByID(int $id):?Author;
    public function getByCPF(CPF $CPF):?Author;

    public function getAll(AuthorSearchOptions $authorSearchOptions):array;
    public function update(Author $author):void;
    public function delete(int $id):void;
}