<?php

namespace app\Util\Enums;

enum TipoRequest
{
    case POST;
    case GET;
    case DELETE;
    case PUT;
    case PATCH;
}