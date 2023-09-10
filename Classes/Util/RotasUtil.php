<?php

namespace util;

use router\RotaPattern;
use stdClass;

class RotasUtil{
    public static function getUri():string{
        $uri = str_replace('/' . DIR_PROJETO, '', $_SERVER['REQUEST_URI']);
        return $uri;
    }

    public static function getMetodo():string{
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param StdClass rota;
     */
    public static function getDadosRota(string $uri, stdClass $rota):array{
        $indice = 0;
        $retorno = array();

        if(substr_count($uri, '/') !== substr_count($uri, '/')){
            return $retorno;
        }

        $explode_rota_uri = explode('/', $rota->uri,);
        $explode_uri = explode('/', $uri);

        for ($i=0; $i < count($explode_rota_uri); $i++) { 
            if($explode_rota_uri[$i] === ''){
                continue;
            }

            foreach(RotaPattern::getPatterns() as $key => $value){
                if($explode_rota_uri[$i] === '(:' . $key . ')'){

                    if(key_exists($indice, $rota->apelido)){
                        array_push($retorno, [$rota->apelido[$indice] => $explode_uri[$i]]);
                    }else{
                        array_push($retorno, ['dados_' . $indice => $explode_uri[$i]]);  
                    }

                    $indice++;
                }
            }
        }

        return $retorno;
    }

    public static function getDadosHeader():array{
        return getallheaders();
    }
}