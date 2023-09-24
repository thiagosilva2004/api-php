<?php

namespace tests\router;

use app\util\RotasUtil;
use PHPUnit\Framework\TestCase;
use stdClass;

class RotaUtilTest extends TestCase
{
    public function testGetDadosRotasDiferentes(): void
    {
        $rota = new stdClass;
        $rota->metodo = null;
        $rota->uri = '/usuarios/(:numeric)';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();


        $dadosRota = (RotasUtil::getDadosRota('/teste', $rota));
        $this->assertEquals(array(), $dadosRota);
    }

    public function testGetDadosSemRota():void
    {
        $rota = new stdClass;
        $rota->metodo = null;
        $rota->uri = '';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();

        $dadosRota = (RotasUtil::getDadosRota('', $rota));
        $this->assertEquals(array(), $dadosRota);
    }

    public function testGetDadosSemApelido():void
    {
        $rota = new stdClass;
        $rota->metodo = null;
        $rota->uri = '/usuarios/(:numeric)/(:alpha)/(:any)';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();

        $dadosDeveriamRetornar = array(array("dados_0"=>"1"),
                                       array("dados_1"=>"nome"),
                                       array("dados_2"=>"maria1212"));

          
        $dadosRota = (RotasUtil::getDadosRota('/usuarios/1/nome/maria1212', $rota));

        $this->assertEquals($dadosDeveriamRetornar, $dadosRota);
    }

    public function testGetDadosComApelidoCompleto():void
    {
        $rota = new stdClass;
        $rota->metodo = null;
        $rota->uri = '/usuarios/(:numeric)/(:alpha)/(:any)';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array('usuario_id', 'filtro','nome');

        $dadosDeveriamRetornar = array(array("usuario_id"=>"1"),
                                       array("filtro"=>"nome"),
                                       array("nome"=>"maria1212"));

          
        $dadosRota = (RotasUtil::getDadosRota('/usuarios/1/nome/maria1212', $rota));

        $this->assertEquals($dadosDeveriamRetornar, $dadosRota);
    }

    public function testGetDadosComApelidoIncompleto():void
    {
        $rota = new stdClass;
        $rota->metodo = null;
        $rota->uri = '/usuarios/(:numeric)/(:alpha)/(:any)';
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array('usuario_id');

        $dadosDeveriamRetornar = array(array("usuario_id"=>"5"),
                                       array("dados_1"=>"documento"),
                                       array("dados_2"=>"11111111"));

          
        $dadosRota = (RotasUtil::getDadosRota('/usuarios/5/documento/11111111', $rota));

        $this->assertEquals($dadosDeveriamRetornar, $dadosRota);
    }

}
