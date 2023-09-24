<?php

use app\Log\Log;
use app\Principal;

header("Acess-Control-Allow-Origin *");
header('Content-Type: application/json; charset=UTF-8');

try {
    include_once 'config.php';

    $principal = new Principal();
    $retorno = $principal->tratarRequisicao();
    echo json_encode($retorno);
    http_response_code(200);

} catch (\Throwable $th) {
   http_response_code(500);

   $log = new Log('Erro insperado', 'Principal', $th->getMessage());
   $log->gravarLog();
}