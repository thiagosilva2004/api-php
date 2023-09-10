<?php

    namespace Log;

    interface LogInterface{

        public function gravarLog():void;

        public function getMensagem():string;
        public function setMensagem(string $mensagem);

        public function getLocal():string;
        public function setLocal(string $local);

        public function getExcecao():string;
        public function setExcecao(string $excecao);

        public function getDadosRecebidos():string;
        public function setDadosRecebidos(string $linha);

        public function getSql():string;
        public function setSql(string $sql);
    }