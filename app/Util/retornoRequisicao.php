<?php

namespace App\Util;

use stdClass;

class RetornoRequisicao{
    public static function getInstance()
    {
        $retornoRequisicao = new StdClass;
    
        $retornoRequisicao->sucesso = false;
        $retornoRequisicao->mensagem = '';
        $retornoRequisicao->dados = array();
    
        return $retornoRequisicao;
    }
}


