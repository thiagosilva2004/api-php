<?php

namespace App\router;

use App\controller\Usuario;
use App\router\middlewares\ValidarToken;
use App\Util\Enums\TipoRequest;
use stdClass;

class Rota
{
    private array $rotas;

    public function __construct()
    {
        $this->rotas = array();
    }

    public function getRotas(): array
    {
        return $this->rotas;
    }

    private function getInstanceRota(): stdClass
    {
        $rota = new stdClass;
        $rota->metodo = null;
        $rota->uri = null;
        $rota->controller_di_build = '';
        $rota->controller_funtion_name = '';
        $rota->middlewares_di_build = array();
        $rota->apelido = array();
        $rota->nivel_acesso = 0;
        return $rota;
    }

    public function addGroup(string $uri, string $controller_di_build, array $middlewares_di_build = array()): void
    {
        $this->addRota(TipoRequest::GET, '/' . $uri . '/(:numeric)', $controller_di_build, 'buscarPeloID', $middlewares_di_build, array($uri . '_id'));
        $this->addRota(TipoRequest::GET, '/' . $uri, $controller_di_build, 'buscarTodos', $middlewares_di_build);
        $this->addRota(TipoRequest::POST, '/' . $uri, $controller_di_build, 'inserir', $middlewares_di_build);
        $this->addRota(TipoRequest::PUT, '/' . $uri, $controller_di_build, 'alterar', $middlewares_di_build);
        $this->addRota(TipoRequest::PATCH, '/' . $uri, $controller_di_build, 'alterarParcialmente', $middlewares_di_build);
        $this->addRota(TipoRequest::DELETE, '/' . $uri, $controller_di_build, 'apagar', $middlewares_di_build);
    }

    public function gerarRotas(): void
    {
        $this->addRota(
            metodo: TipoRequest::POST,
            uri: '/login',
            controller_di_build: Usuario::class,
            controller_funtion_name: 'validarLogin'
        );
        $this->addGroup(uri:'usuarios', controller_di_build:Usuario::class, middlewares_di_build:[ValidarToken::class]);
    }

    public function addRota(TipoRequest $metodo, string $uri, string $controller_di_build, string $controller_funtion_name, array $middlewares_di_build = array(), array $apelido = array(),int $nivel_acesso = 0): void
    {
        $rota = $this->getInstanceRota();
        $rota->metodo = $metodo;
        $rota->uri = $uri;
        $rota->controller_di_build = $controller_di_build;
        $rota->controller_funtion_name = $controller_funtion_name;
        $rota->middlewares_di_build = $middlewares_di_build;
        $rota->apelido = $apelido;
        $rota->nivel_acesso = $nivel_acesso;

        array_push($this->rotas, $rota);
    }
}
