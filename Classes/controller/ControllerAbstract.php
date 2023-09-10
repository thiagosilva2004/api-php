<?php

    namespace controller;

use DB\DB;
use Log\LogInterface;
use stdClass;

    abstract class ControllerAbstract{
        private object $db;
        private LogInterface $log;
        protected array $dadosRecebidos;
        
        public function __construct(object $db, LogInterface $log, array $dadosRecebidos)
        {
            $this->db = $db;
            $this->log = $log;   
            $this->dadosRecebidos = $dadosRecebidos;         
        }

        public abstract function inserir():stdClass;
        public abstract function apagar():stdClass;
        public abstract function alterar():stdClass;
        public abstract function alterarParcialmente():stdClass;
        public abstract function buscarTodos():stdClass;
        public abstract function buscarPeloID():stdClass;

        public function getDadosRecebidos():array
        {
            return $this->dadosRecebidos;
        }

        public function setDadosRecebidos(array $dadosRecebidos):void
        {
            $this->dadosRecebidos = $dadosRecebidos;
        }
    }