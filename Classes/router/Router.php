<?php

namespace router;

use stdClass;
use util\RotasUtil;

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
        $retorno = GetInstanceRetornoRequisicao();

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

                return call_user_func($rota->controller, $this->dadosRecebidos);

                break;
            }
        }

        if (!$uri_encontrada) {
            http_response_code(404);
        }

        return $retorno;
    }
}
