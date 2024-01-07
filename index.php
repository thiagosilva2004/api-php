<?php

use App\Log\Log;
use App\Principal;
use App\Util\ConstantesGenericasUtil;

header('Acess-Control-Allow-Origin *');
header('Content-Type: application/json; charset=UTF-8');

try {
    require_once 'vendor/autoload.php';
    require_once 'bootstrap.php';

    $principal = new Principal();
    $retorno = $principal->tratarRequisicao();
    echo $retorno;
    http_response_code(200);
} catch (\Throwable $th) {
   echo '{"erro": "' . ConstantesGenericasUtil::MSG_ERRO_INSPERADO . '"}'; 
   http_response_code(500);
   $log = new Log('Erro insperado', 'Principal', $th->getMessage());
   $log->gravarLog();
}