<?php

namespace App\presentation\middlewares;

use App\web\request\NetworkRequest;
use App\web\request\NetworkResponse;
use App\web\token\TokenInterface;

class ValidarToken implements MiddlewaresInterface
{

    private TokenInterface $Token;

    public function __construct(TokenInterface $tokenInterface)
    {
        $this->Token = $tokenInterface;
    }

    public function execute(NetworkRequest $networkRequest):NetworkResponse{
        return new NetworkResponse();
        
        /*

        $retorno = RetornoRequisicao::getInstance();
        $retorno->sucesso = false;
        $retorno->mensagem = "token inválido";

        if(!isset($dadosHeader['token'])){
            return $retorno;
        }

        if(!$this->Token->validarToken($dadosHeader['token'])){
            return $retorno;
        }

        $retorno->sucesso = true;
        $retorno->msg = "token válido";

        return $retorno;

        */
    }
}
