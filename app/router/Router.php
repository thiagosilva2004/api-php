<?php

namespace App\router;

use App\util\RotasUtil;
use App\Util\RetornoRequisicao;
use App\Util\ConstantesGenericasUtil;
use stdClass;

class Router
{
    private readonly Rota $rota;
    private readonly RotaComparacao $rotaComparacao;
    private readonly array $dadosRecebidos;

    public function __construct(Rota $rota, RotaComparacao $rotaComparacao, array $dadosRecebidos)
    {
        $this->rota = $rota;
        $this->rotaComparacao = $rotaComparacao;
        $this->dadosRecebidos = $dadosRecebidos;
    }

    public function processar_uri(): stdClass
    {
        $uri_encontrada = false;
        $retorno = RetornoRequisicao::getInstance();   

        foreach ($this->rota->getRotas() as $rota) {
            if ($this->rotaComparacao->compara($rota)) {

                $uri_encontrada = true;

                foreach ($rota->middlewares as $middleware) {
                    $retorno = call_user_func($middleware, 
                                              $this->dadosRecebidos, 
                                              RotasUtil::getDadosRota($this->rotaComparacao->getUri(), $rota),
                                              RotasUtil::getDadosHeader() 
                                              );

                    if ($retorno->sucesso !== true) {
                        return $retorno;
                        break;
                    }
                }

                $retorno = call_user_func($rota->controller, $this->dadosRecebidos, RotasUtil::getDadosRota($this->rotaComparacao->getUri(), $rota),RotasUtil::getDadosHeader());

                break;
            }
        }

        if (!$uri_encontrada) {
            http_response_code(404);
            die;
            exit;
        }

        if($retorno->mensagem === ConstantesGenericasUtil::MSG_ERRO_INSPERADO){
            http_response_code(500);
            die;
            exit;
        }

        // criar class responsavel por verificar e responder os status http

        return $retorno;
    }
}
