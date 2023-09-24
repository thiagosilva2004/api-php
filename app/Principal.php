<?php

namespace app;

use controller\Token as TokenController;
use app\DB\DB;
use app\Log\Log;

use app\controller\Usuario as UsuarioController;
use app\model\Usuario as UsuarioModel;
use app\router\middlewares\ValidarToken;
use app\router\Rota;
use app\router\RotaComparacao;
use app\router\Router;
use app\Util\Enums\TipoRequest;
use app\Util\JsonUtil;
use app\Util\RotasUtil;
use app\Util\token\TokenJWT;
use stdClass;

    class Principal{

        // classes depedencias
        private readonly Log $log;
        private readonly object $db;

        // models
        private readonly UsuarioModel $usuarioModel;

        // controllers
        private readonly UsuarioController $usuarioController;
        private readonly TokenController $tokenController; 
        private readonly TokenJWT $tokenJWT;

        // middlewares
        private readonly ValidarToken $validarToken;

        public array $dadosRecebidos; 
        private readonly TipoRequest $metodo;
        private readonly string $uri;

        private readonly Rota $rota;
        private readonly Router $router;
        private readonly RotaComparacao $rotaComparacao;

        public function __construct()
        {
            // classes depedencias
            $this->log = new Log();
            $this->db = DB::getInstance();
            $this->tokenJWT = new TokenJWT(CHAVE_JWT,ISS, AUD);

            // models
            $this->usuarioModel = new UsuarioModel($this->db, $this->log);  

            // controllers
            $this->usuarioController = new UsuarioController($this->db, $this->log, $this->usuarioModel);             
            $this->tokenController= new TokenController($this->tokenJWT);

            // middlewares
            $this->validarToken = new ValidarToken($this->tokenJWT);
        }

        
        /**
         * @return StdClass retornoRequisicao;
         */
        public function tratarRequisicao():stdClass{
            $this->dadosRecebidos = JsonUtil::tratarCorpoRequisicaoJson();

            $this->uri = RotasUtil::getUri();
            $this->metodo = RotasUtil::getMetodo();

            $this->rota = new Rota();
            $this->rota->setUsuarioController($this->usuarioController);
            $this->rota->setTokenController($this->tokenController);
            $this->rota->setValidarTokenMiddlewares($this->validarToken);

            $this->rota->gerarRotas();

            $this->rotaComparacao = new RotaComparacao($this->uri, $this->metodo);
            $this->router = new Router($this->rota, $this->rotaComparacao, $this->dadosRecebidos);
            return $this->router->processar_uri();
        }
    }