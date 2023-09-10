<?php

namespace router;

use Closure;
use controller\ControllerAbstract;
use controller\Token;
use controller\Usuario;
use router\middlewares\ValidarToken as MiddlewaresValidarToken;
use stdClass;

class Rota
{

    private array $rotas;
    private Usuario $usuarioController;
    private Token $tokenController;
    private MiddlewaresValidarToken $validarTokenMiddlewares;

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
        $rota->controller = null;
        $rota->middlewares = array();
        $rota->apelido = array();
        return $rota;
    }

    public function addGroup(string $uri, ControllerAbstract $controller, array $middleware = array()): void
    {
        $this->addRota('GET', '/' . $uri . '/(:numeric)', $controller->buscarPeloID(...), $middleware, array($uri . '_id'));
        $this->addRota('GET', '/' . $uri, $controller->buscarTodos(...), $middleware);
        $this->addRota('POST', '/' . $uri, $controller->inserir(...), $middleware);
        $this->addRota('PUT', '/' . $uri, $controller->alterar(...), $middleware);
        $this->addRota('PATCH', '/' . $uri, $controller->alterarParcialmente(...), $middleware);
        $this->addRota('DELETE', '/' . $uri, $controller->apagar(...), $middleware);
    }

    public function gerarRotas(): void
    {
        $this->addRota('GET', '/token', $this->tokenController->gerarToken(...));
        $this->addGroup('usuarios', $this->usuarioController, [$this->validarTokenMiddlewares->execute(...)]);
    }

    public function addRota(string $metodo, string $uri, Closure $controller, array $middleware = array(), array $apelido = array()): void
    {
        $rota = $this->getInstanceRota();
        $rota->metodo = $metodo;
        $rota->uri = $uri;
        $rota->controller = $controller;
        $rota->middlewares = $middleware;
        $rota->apelido = $apelido;

        array_push($this->rotas, $rota);
    }

    public function setUsuarioController(Usuario $usuarioController): void
    {
        $this->usuarioController = $usuarioController;
    }

    public function setTokenController(Token $tokenController): void
    {
        $this->tokenController = $tokenController;
    }

    public function setValidarTokenMiddlewares(MiddlewaresValidarToken $validarTokenMiddlewares):void
    {
        $this->validarTokenMiddlewares = $validarTokenMiddlewares;
    }
}
