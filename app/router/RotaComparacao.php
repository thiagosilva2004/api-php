<?php

namespace app\router;

use app\Util\Enums\TipoRequest;
use stdClass;

    class RotaComparacao{

        private string $wildcardReplaced;

        private string $uri;
        private TipoRequest $metodo;

        public function __construct(string $uri,TipoRequest $metodo)
        {
            $this->uri = $uri;
            $this->metodo= $metodo;
        }

        /**
         * @param StdClass rota;
         */
        public function compara(stdClass $rota):bool{
            $this->replaceWildcardWithPattern($rota->uri);
            
            return 
                $this->uriEqualToPattern($this->uri, $this->wildcardReplaced) &&
                $rota->metodo === $this->metodo;
        }

        private function replaceWildcardWithPattern(string $uriToReplace):void
        {
          $this->wildcardReplaced = $uriToReplace;
        
          foreach(RotaPattern::getPatterns() as $key => $value){
            if (str_contains($this->wildcardReplaced, '(:' . $key . ')')) {
              $this->wildcardReplaced = str_replace('(:' . $key . ')', $value, $this->wildcardReplaced);
            }   
          }
        }
      
        private function uriEqualToPattern($currentUri, $wildcardReplaced):bool
        {
          $wildcard = str_replace('/', '\/', ltrim($wildcardReplaced, '\/'));    
          return preg_match("/^$wildcard$/", ltrim($currentUri, '/'));
        }

        public function getUri():string
        {
            return $this->uri;
        }

        public function setUri($uri):void
        {
            $this->uri = $uri;
        }

        public function getMetodo():TipoRequest
        {
            return $this->metodo;
        }

        public function setMetodoAtual($metodo):void
        {
            $this->metodo = $metodo;
        }
    }