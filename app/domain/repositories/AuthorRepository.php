<?php

namespace App\domain\repositories;

use App\application\contracts\AuthorRepositoryInterface;
use App\application\SearchOptions\AuthorSearchOptions;
use App\domain\entities\Author;
use App\domain\entities\AuthorSummary;
use App\domain\valueObjects\CPF;
use App\infrastructure\database\contracts\AuthorRepositoryHelperDatabaseInterface;

class AuthorRepository implements AuthorRepositoryInterface
{

    public function __construct(
        private readonly AuthorRepositoryHelperDatabaseInterface $authorRepositoryHelperDatabase
    ){}

    public function add(Author $author): int
    {
        return $this->authorRepositoryHelperDatabase->add($author);
    }

    public function getByID(int $id): ?Author
    {
        return $this->authorRepositoryHelperDatabase->getByID($id);
    }

    public function getByCPF(CPF $CPF): ?Author
    {
        return $this->authorRepositoryHelperDatabase->getByCPF($CPF);
    }

    /**
     * @param AuthorSearchOptions $authorSearchOptions
     * @return array<AuthorSummary>
     */
    public function getAll(AuthorSearchOptions $authorSearchOptions): array
    {
        return $this->authorRepositoryHelperDatabase->getAll($authorSearchOptions);
    }

    public function update(Author $author): bool
    {
        $this->authorRepositoryHelperDatabase->update($author);
        return true;
    }

    public function delete(int $id): bool
    {
        $this->authorRepositoryHelperDatabase->delete($id);
        return true;
    }

    public function existWithID(int $author_id): bool
    {
        return !is_null($this->authorRepositoryHelperDatabase->getByID($author_id));
    }

    public function existWithCPF(CPF $CPF): bool
    {
        return !is_null($this->authorRepositoryHelperDatabase->getByCPF($CPF));
    }
}