<?php

namespace App\web\router;

use App\web\router\routes\Author;

class RotaListGet
{
    public function get():array
    {
        return array_merge(Author::getRoutes());
    }
}