<?php

    function GetInstanceRetornoRequisicao(){
        $retornoRequisicao = new StdClass;

        $retornoRequisicao->sucesso = false;
        $retornoRequisicao->mensagem = '';
        $retornoRequisicao->dados = array();
        
        return $retornoRequisicao;
    }