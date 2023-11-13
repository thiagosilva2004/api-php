<?php

use App\Log\Log;
use App\Principal;
use App\Util\ConstantesGenericasUtil;

header('Acess-Control-Allow-Origin *');
header('Content-Type: application/json; charset=UTF-8');

try {
    include_once 'config.php';
    require_once 'vendor/autoload.php';

    $principal = new Principal();
    $retorno = $principal->tratarRequisicao();
    echo json_encode($retorno);
    http_response_code(200);
} catch (\Throwable $th) {
   echo '{"erro": "' . ConstantesGenericasUtil::MSG_ERRO_INSPERADO . '"}'; 
   http_response_code(500);
   $log = new Log('Erro insperado', 'Principal', $th->getMessage());
   $log->gravarLog();
}