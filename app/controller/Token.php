<?php

namespace controller;

use app\Util\token\TokenInterface;
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
        $retorno = GetInstanceRetornoRequisicao();

        $dadosRetorno = ['token' => $this->tokenClass->gerarToken()];
        $retorno->sucesso = true;

        $retorno->dados = $dadosRetorno;
        return $retorno;
    }
}
