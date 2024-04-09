<?php

namespace App\infrastructure\database\types;

class DatabaseParams
{
    public function __construct(
        public string $name,
        public mixed $value,
        public DatabaseParamsType $type,
        public int $length = 0
    ){}
}