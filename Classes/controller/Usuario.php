<?php

namespace controller;

use DB\DB;
use Log\LogInterface;
use model\Usuario as UsuarioModel;
use stdClass;

class Usuario extends ControllerAbstract{

    private UsuarioModel $usuarioModel;

    public function __construct(object $db, LogInterface $log,UsuarioModel $usuarioModel, array $dadosRecebidos = array())
    {
        $this->usuarioModel = $usuarioModel;
        parent::__construct($db, $log, $dadosRecebidos);
    }

    public function inserir():stdClass{
        return GetInstanceRetornoRequisicao();
    }

    public function apagar():stdClass{
        return GetInstanceRetornoRequisicao();
    }

    public function alterar():stdClass{
        return GetInstanceRetornoRequisicao();
    }

    public function alterarParcialmente():stdClass{
        return GetInstanceRetornoRequisicao();
    }


    public function validarLogin():stdClass{
        return GetInstanceRetornoRequisicao();
    }

    public function buscarTodos():stdClass
    {
        return GetInstanceRetornoRequisicao();
    }

    public function buscarPeloID():stdClass
    {
        return GetInstanceRetornoRequisicao();
    }

}