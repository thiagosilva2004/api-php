<?php

namespace App\controller;

use App\DB\DB;
use App\Log\LogInterface;
use stdClass;

abstract class ControllerAbstract
{
    protected object $db;
    protected LogInterface $log;

    public function __construct(object $db, LogInterface $log)
    {
        $this->db = $db;
        $this->log = $log;
    }

    public abstract function inserir(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass;
    public abstract function apagar(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass;
    public abstract function alterar(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass;
    public abstract function alterarParcialmente(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass;
    public abstract function buscarTodos(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass;
    public abstract function buscarPeloID(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass;
}
