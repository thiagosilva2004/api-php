<?php

namespace tests\router;

use app\router\RotaComparacao;
use app\Util\Enums\TipoRequest;
use PHPUnit\Framework\TestCase;
use stdClass;

class RotaComparacaoTest extends TestCase
{
    public function testComparaRotaIgual(): void
    {
        $rota = new stdClass;
        $rota->metodo = TipoRequest::POST;
        $rota->uri = '/usuarios/(:numeric)';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();

        $rotaComparacao = new RotaComparacao('/usuarios/2', TipoRequest::POST);
        $this->assertTrue($rotaComparacao->compara($rota));
    }

    public function testComparaRotaDiferente(): void
    {
        $rota = new stdClass;
        $rota->metodo = TipoRequest::POST;
        $rota->uri = '/usuarios';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();

        $rotaComparacao = new RotaComparacao('/usuarios/2', TipoRequest::POST);
        $this->assertFalse($rotaComparacao->compara($rota));
    }

    public function testComparaRotaMetodoDiferente(): void
    {
        $rota = new stdClass;
        $rota->metodo = 'get';
        $rota->uri = '/usuarios';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();

        $rotaComparacao = new RotaComparacao('/usuarios/2', TipoRequest::POST);
        $this->assertFalse($rotaComparacao->compara($rota));
    }

}
