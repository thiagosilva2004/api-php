<?php

namespace App\web\request;

use Exception;

enum RequestType
{
    case POST;
    case GET;
    case DELETE;
    case PUT;
    case PATCH;

    public static function getType(string $requestType): RequestType
    {
        return match(strtoupper($requestType)) {
            'POST' => self::POST,
            'GET' => self::GET,
            'DELETE' => self::DELETE,
            'PUT' => self::PUT,
            'PATCH' => self::PATCH,
            default => New Exception("Request type not found in definitions"),
        };
    }
}