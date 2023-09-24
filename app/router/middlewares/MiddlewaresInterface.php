<?php

namespace app\router\middlewares;

use stdClass;

interface MiddlewaresInterface{
    /**
     * @return StdClass retornoRequisicao;
     */
    public function execute(array $dadosRecebidos, array $dadosRotas, array $dadosHeader):stdClass;
}