<?php

namespace App\web\request;

use Throwable;

class HttpRequestData
{
    public static function getUri():string{
        return str_replace('/' . $_ENV['DIR_PROJETO'], '', $_SERVER['REQUEST_URI']);
    }

    public static function getRequestType():RequestType
    {
        return RequestType::getType($_SERVER['REQUEST_METHOD']);
    }

    public static function getRequestBodyData():array|false{
        $body = file_get_contents('php://input');
        $body = rtrim($body, '"');
        $body = ltrim($body, '"');

        if (empty($body)){
            return array();
        }

        try {
            $postJson = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $throwable) {
            return false;
        }

        if(is_array($postJson) && count($postJson) > 0){
            return $postJson;
        }

        return array();
    }
}