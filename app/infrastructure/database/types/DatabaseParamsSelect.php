<?php

namespace App\infrastructure\database\types;

class DatabaseParamsSelect
{
    public function __construct(
        public string $name,
        public mixed $value,
        public DatabaseParamsSelectType $type,
    ){}
}