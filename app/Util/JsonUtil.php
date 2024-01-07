<?php

namespace App\Util;

use App\Log\Log;
use InvalidArgumentException;
use JsonException;

class JsonUtil{
    public static function tratarCorpoRequisicaoJson():array{
        try {
            $body = file_get_contents('php://input');
            $body = rtrim($body, '"');
            $body = ltrim($body, '"');

            $postJson = json_decode($body, true);
        } catch (JsonException $e) {
            $log = new Log('erro: ' . $e->getMessage());
            $log->gravarLog();

            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
        }

        if(is_array($postJson) && count($postJson) > 0){
            return $postJson;
        }else{
            return array();
        }
    }
}