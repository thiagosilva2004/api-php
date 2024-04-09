<?php

namespace App\web\request;

use App\presentation\languages\LanguageFacade;
use App\presentation\languages\LanguageItems;
use stdClass;

class RequestSendResponse
{

    public static function execute(NetworkResponse $networkResponse): never
    {
        http_response_code($networkResponse->code);

        if($networkResponse->success){
            if(count($networkResponse->data) > 0){
                echo json_encode(value: $networkResponse->data,
                                 flags: JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_OBJECT_AS_ARRAY
                );
            }
        }else{
            $responseError = new stdClass();
            $responseError->success = false;

            $responseError->message = ($networkResponse->message instanceof LanguageItems) ?
                LanguageFacade::getValue($networkResponse->message) :
                $networkResponse->message;

            echo json_encode(value: $responseError, flags: JSON_THROW_ON_ERROR);
        }

        die;
    }
}