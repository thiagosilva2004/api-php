<?php

namespace controller;

use stdClass;
use Util\token\TokenInterface as TokenInterface;

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
