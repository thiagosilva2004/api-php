<?php

namespace App\infrastructure\database\repositoryHelper;

use App\application\SearchOptions\AuthorSearchOptions;
use App\domain\entities\Author;
use App\domain\entities\AuthorSummary;
use App\domain\valueObjects\CPF;
use App\domain\valueObjects\Sex;
use App\infrastructure\database\contracts\AuthorRepositoryHelperDatabaseInterface;
use App\infrastructure\database\contracts\DatabaseContextInterface;
use App\infrastructure\database\types\DatabaseParams;
use App\infrastructure\database\types\DatabaseParamsSelect;
use App\infrastructure\database\types\DatabaseParamsSelectType;
use App\infrastructure\database\types\DatabaseParamsType;

class AuthorRepositoryHelperDatabase implements AuthorRepositoryHelperDatabaseInterface
{

    private string $tableName = "author";

    public function __construct
    (
      private readonly DatabaseContextInterface $databaseContext
    ){}

    public function add(Author $author): int
    {
        $params = array(
            new DatabaseParams('name',$author->getName(), DatabaseParamsType::STRING, 100),
            new DatabaseParams('sex',$author->getSex()->toString(), DatabaseParamsType::STRING, 1),
            new DatabaseParams('cpf',$author->getCpf()->getValue(), DatabaseParamsType::STRING,11),
        );

        $this->databaseContext->save($this->tableName,$params);
        return $this->databaseContext->getLastInsertID();
    }

    public function getByID(int $id): ?Author
    {
        $param = new DatabaseParamsSelect("id",$id,DatabaseParamsSelectType::STRING_EQUALS);
        $selectResponse = $this->databaseContext->select($this->tableName,[],[$param]);
        return is_null($selectResponse) ? null : $this->selectToAuthor($selectResponse);
    }

    public function getByCPF(CPF $CPF): ?Author
    {
        $param = new DatabaseParamsSelect("cpf",$CPF->getValue(),DatabaseParamsSelectType::STRING_EQUALS);
        $selectResponse = $this->databaseContext->select($this->tableName,[],[$param]);
        return is_null($selectResponse) ? null : $this->selectToAuthor($selectResponse);
    }

    /**
     * @param AuthorSearchOptions $authorSearchOptions
     * @return array<AuthorSummary>
     */
    public function getAll(AuthorSearchOptions $authorSearchOptions): array
    {
        $response = $this->databaseContext->select(
                tableName:  $this->tableName,
                columns: ['id, name'],
                params: $this->authorSearchOptionsToParams($authorSearchOptions));
        return is_null($response) ? [] : $response;
    }

    public function update(Author $author): void
    {
        $params = array(
            new DatabaseParams('name',$author->getName(), DatabaseParamsType::STRING, 100),
            new DatabaseParams('sex',$author->getSex()->toString(), DatabaseParamsType::STRING, 1),
            new DatabaseParams('cpf',$author->getCpf()->getValue(), DatabaseParamsType::STRING,11),
        );

        $this->databaseContext->update($this->tableName,$params, $author->getId());
    }

    public function delete(int $id): void
    {
        $this->databaseContext->delete($this->tableName,$id);
    }

    private function selectToAuthor(array $selectResponse): ?Author
    {
        if(count($selectResponse) == 0){
            return null;
        }

        $cpf = CPF::create($selectResponse[0]['cpf']);
        $sex = Sex::stringToSex($selectResponse[0]['sex']);

        return Author::create(
          id: $selectResponse[0]['id'],
          name: $selectResponse[0]['name'],
          cpf: $cpf,
          sex: $sex,
        );
    }

    private function authorSearchOptionsToParams(AuthorSearchOptions $authorSearchOptions):array
    {
        $params = [];
        if(!is_null($authorSearchOptions->name)){
            $params[] = new DatabaseParamsSelect(
                "name", $authorSearchOptions->name,
                DatabaseParamsSelectType::STRING_EQUALS);
        }
        return $params;
    }
}