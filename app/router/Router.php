<?php

namespace App\router;

use App\util\RotasUtil;
use App\Util\RetornoRequisicao;
use App\Util\ConstantesGenericasUtil;
use App\Util\ContainerBuilder;
use stdClass;

class Router
{
    public function __construct(private readonly Rota $rota, 
                                private readonly RotaComparacao $rotaComparacao, 
                                private readonly array $dadosRecebidos){}

    public function processar_uri(): stdClass
    {
        $uri_encontrada = false;
        $retorno = RetornoRequisicao::getInstance();   
        $containerBuilder = ContainerBuilder::getInstance();

        foreach ($this->rota->getRotas() as $rota) {
            if ($this->rotaComparacao->compara($rota)) {

                $uri_encontrada = true;

                foreach ($rota->middlewares_di_build as $rota_middleware) {
                    $middleware = $containerBuilder->get($rota_middleware);

                    $retorno = call_user_func($middleware->execute, 
                                              $this->dadosRecebidos, 
                                              RotasUtil::getDadosRota($this->rotaComparacao->getUri(), $rota),
                                              RotasUtil::getDadosHeader() 
                                              );

                    if ($retorno->sucesso !== true) {
                        return $retorno;
                        break;
                    }
                }

                $controller = $containerBuilder->get($rota->controller_di_build);
                $funcao = $rota->controller_funtion_name;
                $retorno = $controller->$funcao(
                                                $this->dadosRecebidos, 
                                                RotasUtil::getDadosRota($this->rotaComparacao->getUri(), $rota),
                                                RotasUtil::getDadosHeader()
                                            );

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

        return $retorno;
    }
}
