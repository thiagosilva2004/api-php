<?php

namespace App\web\router;

use App\web\request\RequestType;
use App\web\router\routes\Author;
use stdClass;

class Rota
{
    private array $rotas = array();

    public function __construct(
      private RotaListGet $rotaListGet
    ){}

    /**
     * @return array<RotaSchema>
     */
    public function getRotas(): array
    {
        return $this->rotas;
    }

    public function addGroup(string $uri, string $controller_class_name, array $middlewares_di_build = array()): void
    {
        $this->addRota(RequestType::GET, '/' . $uri . '/(:numeric)', $controller_class_name, 'getByID', $middlewares_di_build, array($uri . '_id'));
        $this->addRota(RequestType::GET, '/' . $uri, $controller_class_name, 'getAll', $middlewares_di_build);
        $this->addRota(RequestType::POST, '/' . $uri, $controller_class_name, 'add', $middlewares_di_build);
        $this->addRota(RequestType::PUT, '/' . $uri, $controller_class_name, 'update', $middlewares_di_build);
        $this->addRota(RequestType::PATCH, '/' . $uri, $controller_class_name, 'alterData', $middlewares_di_build);
        $this->addRota(RequestType::DELETE, '/' . $uri, $controller_class_name, 'delete', $middlewares_di_build);
    }

    public function gerarRotas(): void
    {
       $this->rotas = $this->rotaListGet->get();
    }

    public function addRota(
        RequestType $requestType,
        string      $uri,
        string      $controller_class_name,
        string      $controller_function_name,
        array       $middlewares_classes_names = array(),
        array       $datasNicknames = array()
    ): void
    {
        $rota = RotaFactory::create();
        $rota->requestType = $requestType;
        $rota->uri = $uri;
        $rota->controller_class_name = $controller_class_name;
        $rota->controller_function_name = $controller_function_name;
        $rota->middlewares_classes_names = $middlewares_classes_names;
        $rota->datasNicknames = $datasNicknames;

        $this->rotas[] = $rota;
    }
}
