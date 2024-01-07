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

        public function tratarRequisicao():String{
            $this->dadosRecebidos = JsonUtil::tratarCorpoRequisicaoJson();

            $this->uri = RotasUtil::getUri();
            $this->metodo = RotasUtil::getMetodo();

            $this->rota = new Rota();           
            $this->rota->gerarRotas();

            $this->rotaComparacao = new RotaComparacao($this->uri, $this->metodo);
            $this->router = new Router($this->rota, $this->rotaComparacao, $this->dadosRecebidos);

            $retorno = $this->router->processar_uri();

            if($retorno->sucesso){
                return json_encode($retorno->dados);
            }else{
                $retornoErro = new stdClass;
                $retornoErro->sucesso = false;
                $retornoErro->mensagem = $retorno->mensagem;

                return json_encode($retornoErro);
            }
        }
    }