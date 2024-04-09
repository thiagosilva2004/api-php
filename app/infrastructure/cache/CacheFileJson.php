<?php

namespace App\infrastructure\cache;

use App\application\abstractions\CacheDatasInterface;

class CacheFileJson implements CacheDatasInterface
{

    public function __construct(
        private string $path,
        private string $fileName
    ){}
    public function get(): array
    {
        // TODO: Implement get() method.
    }

    public function save(array $datas): void
    {
        // TODO: Implement save() method.
    }
}