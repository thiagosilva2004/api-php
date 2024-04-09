<?php

namespace App\web\router;

use App\web\request\RequestType;

class RotaSchema
{
    public function __construct(
        public RequestType $requestType,
        public string       $uri,
        public string       $controller_class_name,
        public string       $controller_function_name,
        public array        $middlewares_classes_names = [],
        public array        $datasNicknames = []
    ){}
}