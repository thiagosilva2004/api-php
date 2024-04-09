<?php

namespace App\web\router;

use App\web\request\RequestType;

class RotaFactory
{
    public static function create():RotaSchema
    {
        return new RotaSchema(
            requestType: RequestType::GET,
            uri: "",
            controller_class_name: "",
            controller_function_name: "",
            middlewares_classes_names: [],
            datasNicknames: []
        );
    }
}