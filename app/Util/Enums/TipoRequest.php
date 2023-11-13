<?php

namespace App\Util\Enums;

use App\Util\ConstantesGenericasUtil;
use Exception;

enum TipoRequest
{
    case POST;
    case GET;
    case DELETE;
    case PUT;
    case PATCH;

    public static function getType(string $TipoRequest): TipoRequest
    {
        return match(strtoupper($TipoRequest)) {
            'POST' => TipoRequest::POST,
            'GET' => TipoRequest::GET,
            'DELETE' => TipoRequest::DELETE,
            'PUT' => TipoRequest::PUT,
            'PATCH' => TipoRequest::PATCH,
            default => New Exception(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE),
        };
    }
}