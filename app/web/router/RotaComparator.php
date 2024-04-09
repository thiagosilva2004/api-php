<?php

namespace App\web\router;

use App\web\request\RequestType;

class RotaComparator{

        private string $wildcardReplaced;

        public function __construct(
            private string $uri,
            private RequestType $requestType
        ){}

        public function compare(RotaSchema $rota):bool{
            $this->replaceWildcardWithPattern($rota->uri);
            
            return
                $this->uriEqualToPattern($this->uri, $this->wildcardReplaced) &&
                $rota->requestType === $this->requestType;
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

        public function getRequestType():RequestType
        {
            return $this->requestType;
        }

        public function setRequestType($requestType):void
        {
            $this->requestType = $requestType;
        }
    }