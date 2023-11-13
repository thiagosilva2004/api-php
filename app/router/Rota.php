<?php

namespace App\router;

use Closure;
use App\controller\ControllerAbstract;
use App\router\middlewares\ValidarToken as MiddlewaresValidarToken;
use App\Util\Enums\TipoRequest;
use App\Util\ContainerBuilder;
use App\controller\Usuario as UsuarioController;
use stdClass;

class Rota
{

    private array $rotas;
    private UsuarioController $usuarioController;
    private MiddlewaresValidarToken $validarTokenMiddlewares;

    public function __construct()
    {
        $containerBuild = ContainerBuilder::getinstance();
        $this->rotas = array();

        $this->usuarioController = $containerBuild->get('App\controller\Usuario');

        $this->validarTokenMiddlewares = $containerBuild->get('App\router\middlewares\ValidarToken');
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
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();
        return $rota;
    }

    public function addGroup(string $uri, ControllerAbstract $controller, array $middleware = array()): void
    {
        $this->addRota(TipoRequest::GET, '/' . $uri . '/(:numeric)', $controller->buscarPeloID(...), $middleware, array($uri . '_id'));
        $this->addRota(TipoRequest::GET, '/' . $uri, $controller->buscarTodos(...), $middleware);
        $this->addRota(TipoRequest::POST, '/' . $uri, $controller->inserir(...), $middleware);
        $this->addRota(TipoRequest::PUT, '/' . $uri, $controller->alterar(...), $middleware);
        $this->addRota(TipoRequest::PATCH, '/' . $uri, $controller->alterarParcialmente(...), $middleware);
        $this->addRota(TipoRequest::DELETE, '/' . $uri, $controller->apagar(...), $middleware);
    }

    public function gerarRotas(): void
    {
        $this->addRota(TipoRequest::POST, '/login', $this->usuarioController->validarLogin(...));
        $this->addGroup('usuarios', $this->usuarioController, [$this->validarTokenMiddlewares->execute(...)]);
    }

    public function addRota(TipoRequest $metodo, string $uri, Closure $controller, array $middleware = array(), array $apelido = array()): void
    {
        $rota = $this->getInstanceRota();
        $rota->metodo = $metodo;
        $rota->uri = $uri;
        $rota->controller = $controller;
        $rota->middlewares = $middleware;
        $rota->apelido = $apelido;

        array_push($this->rotas, $rota);
    }
}
