<?php

namespace App\router\middlewares;

use app\Util\token\TokenInterface;
use App\Util\RetornoRequisicao;
use stdClass;

class ValidarToken implements MiddlewaresInterface
{

    private TokenInterface $Token;

    public function __construct(TokenInterface $tokenInterface)
    {
        $this->Token = $tokenInterface;
    }

    /**
     * @return StdClass retornoRequisicao;
     */
    public function execute(array $dadosRecebidos, array $dadosRotas, array $dadosHeader):stdClass{
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
    }
}
