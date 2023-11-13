<?php

namespace App;

use App\router\Rota;
use App\router\RotaComparacao;
use App\router\Router;
use App\Util\Enums\TipoRequest;
use App\Util\JsonUtil;
use App\Util\RotasUtil;
use stdClass;

    class Principal{

        public array $dadosRecebidos; 
        private readonly TipoRequest $metodo;
        private readonly string $uri;

        private readonly Rota $rota;
        private readonly Router $router;
        private readonly RotaComparacao $rotaComparacao;

        public function __construct()
        {
          
        }

        
        /**
         * @return StdClass retornoRequisicao;
         */
        public function tratarRequisicao():stdClass{
            $this->dadosRecebidos = JsonUtil::tratarCorpoRequisicaoJson();

            $this->uri = RotasUtil::getUri();
            $this->metodo = RotasUtil::getMetodo();

            $this->rota = new Rota();           
            $this->rota->gerarRotas();

            $this->rotaComparacao = new RotaComparacao($this->uri, $this->metodo);
            $this->router = new Router($this->rota, $this->rotaComparacao, $this->dadosRecebidos);
            return $this->router->processar_uri();
        }
    }