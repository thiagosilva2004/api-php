<?php

namespace App\router\middlewares;

use stdClass;

interface MiddlewaresInterface{
    /**
     * @return StdClass retornoRequisicao;
     */
    public function execute(array $dadosRecebidos, array $dadosRotas, array $dadosHeader):stdClass;
}