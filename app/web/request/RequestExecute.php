<?php

namespace App\web\request;

use App\presentation\languages\LanguageItems;
use App\web\router\Rota;
use App\web\router\RotaComparator;
use App\web\router\RotaData;
use App\web\router\RotaListGet;
use App\web\router\Router;

class RequestExecute
{
    public static function execute():NetworkResponse
    {
        $requestBodyData = HttpRequestData::getRequestBodyData();
        if($requestBodyData === false){
            return  new NetworkResponse(400,LanguageItems::JSON_INVALID);
        }

        $rota = new Rota(new RotaListGet());
        $rota->gerarRotas();
        $rotaComparator = new RotaComparator(HttpRequestData::getUri(), HttpRequestData::getRequestType());
        $rotaData = new RotaData($rotaComparator);
        return (new Router($rota, $rotaComparator, $rotaData, $requestBodyData))->execute_uri();
    }
}