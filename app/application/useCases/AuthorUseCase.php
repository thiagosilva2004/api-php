<?php

namespace App\application\useCases;

use App\application\contracts\AuthorRepositoryInterface;
use App\application\dtos\AuthorUseCaseAddInput;
use App\application\dtos\AuthorUseCaseAddOutput;
use App\application\dtos\AuthorUseCaseDeleteInput;
use App\application\dtos\AuthorUseCaseDeleteOutput;
use App\application\dtos\AuthorUseCaseGetAllInput;
use App\application\dtos\AuthorUseCaseGetAllOutput;
use App\application\dtos\AuthorUseCaseGetByIdInput;
use App\application\dtos\AuthorUseCaseGetByIdOutput;
use App\application\dtos\AuthorUseCaseUpdateInput;
use App\application\dtos\AuthorUseCaseUpdateOutput;
use App\application\SearchOptions\AuthorSearchOptions;
use App\domain\entities\Author;
use App\domain\valueObjects\CPF;
use App\domain\valueObjects\Sex;
use App\presentation\languages\LanguageItems;

class AuthorUseCase
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository
    ){}

    public function add(AuthorUseCaseAddInput $input):AuthorUseCaseAddOutput
    {
        $cpf = CPF::create($input->cpf);
        if ($cpf === false){
            return new AuthorUseCaseAddOutput([LanguageItems::CPF_INVALID],0);
        }

        $sex = Sex::stringToSex($input->sex);
        if ($sex === false){
            return new AuthorUseCaseAddOutput([LanguageItems::SEX_INVALID],0);
        }

        if($this->authorRepository->existWithCPF($cpf)){
            return new AuthorUseCaseAddOutput([LanguageItems::AUTHOR_CPF_ALREADY_CREATED],0);
        }
        $author = Author::create(
            id: 0,
            name: $input->name,
            cpf: CPF::create($input->cpf),
            sex: Sex::stringToSex($input->sex)
        );
        if (!$author instanceof Author){
            return new AuthorUseCaseAddOutput([$author],0);
        }
        return new AuthorUseCaseAddOutput([], $this->authorRepository->add($author));
    }

    public function delete(AuthorUseCaseDeleteInput $input):AuthorUseCaseDeleteOutput
    {
        if($input->author_id <= 0 || is_null($input->author_id)){
            return new AuthorUseCaseDeleteOutput([LanguageItems::AUTHOR_ID_INVALID]);
        }
        if(!$this->authorRepository->existWithID($input->author_id)){
            return new AuthorUseCaseDeleteOutput([LanguageItems::AUTHOR_NOT_FOUND]);
        }
        if(!$this->authorRepository->delete($input->author_id)){
            return new AuthorUseCaseDeleteOutput([LanguageItems::AUTHOR_NOT_DELETE]);
        }
        return new AuthorUseCaseDeleteOutput([]);
    }

    public function update(AuthorUseCaseUpdateInput $input): AuthorUseCaseUpdateOutput
    {
        if(is_null($input->author_id) || $input->author_id <= 0){
            return new AuthorUseCaseUpdateOutput([LanguageItems::AUTHOR_ID_INVALID],null);
        }

        $sex = Sex::stringToSex($input->sex);
        if ($sex === false){
            return new AuthorUseCaseUpdateOutput([LanguageItems::SEX_INVALID]);
        }

        $author = $this->authorRepository->getByID($input->author_id);
        if(is_null($author)){
            return new AuthorUseCaseUpdateOutput([LanguageItems::AUTHOR_NOT_FOUND]);
        }

        $author->setName($input->name);
        $author->setSex($sex);

        $this->authorRepository->update($author);
        return new AuthorUseCaseUpdateOutput([]);
    }

    public function getAll(AuthorUseCaseGetAllInput $input): AuthorUseCaseGetAllOutput{
        return new AuthorUseCaseGetAllOutput(
            errors: [],
            authors: $this->authorRepository->getAll(AuthorSearchOptions::toSearchOptions($input))
        );
    }

    public function getById(AuthorUseCaseGetByIdInput $input): AuthorUseCaseGetByIdOutput{
        if(is_null($input->author_id) || $input->author_id <= 0){
            return new AuthorUseCaseGetByIdOutput([LanguageItems::AUTHOR_ID_INVALID],null);
        }
        $author = $this->authorRepository->getByID($input->author_id);
        if(is_null($author)){
            return new AuthorUseCaseGetByIdOutput([LanguageItems::AUTHOR_NOT_FOUND],null);
        }
        return new AuthorUseCaseGetByIdOutput([],$author);
    }
}