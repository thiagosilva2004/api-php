<?php

namespace App\domain\entities;

use App\domain\valueObjects\CPF;
use App\domain\valueObjects\Sex;
use App\presentation\languages\LanguageItems;
use JsonSerializable;

/**
 * implementar JsonSerializable e necessario pois o PHP nao consegue tratar corretamente os dados do valueObject
 */
class Author implements JsonSerializable
{

    public static function create(int $id, string $name, CPF $cpf, Sex $sex):Author|LanguageItems
    {
        if(!self::isValidName($name)){
            return LanguageItems::AUTHOR_NAME_IS_INVALID;
        }
        return new Author($id,$name,$cpf,$sex);
    }

    private function __construct(
        private int $id,
        private string $name,
        private CPF $cpf,
        private Sex $sex
    ){}

    public static function isValidName(string $name):bool
    {
        return strlen($name) >= 3;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): bool
    {
        if(!self::isValidName($name)){
            return false;
        }

        $this->name = $name;
        return true;
    }

    public function getCpf(): CPF
    {
        return $this->cpf;
    }

    public function setCpf(CPF $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getSex(): Sex
    {
        return $this->sex;
    }

    public function setSex(Sex $sex): void
    {
        $this->sex = $sex;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf->getValue(),
            'sex' => $this->sex->toString()
        ];
    }
}