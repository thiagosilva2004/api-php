<?php

namespace App\controller;

use App\Util\RetornoRequisicao;
use App\Util\token\TokenInterface;
use stdClass;
class Token
{

    private TokenInterface $tokenClass;

    public function __construct(TokenInterface $tokenClass)
    {
        $this->tokenClass = $tokenClass;
    }

    /**
     * @return StdClass retornoRequisicao;
     */
    public function gerarToken(array $dados): stdClass
    {      
        $retorno = RetornoRequisicao::getInstance();

        $dadosRetorno = ['token' => $this->tokenClass->gerarToken()];
        $retorno->sucesso = true;

        $retorno->dados = $dadosRetorno;
        return $retorno;
    }
}
