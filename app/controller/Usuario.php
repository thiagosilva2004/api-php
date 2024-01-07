<?php

namespace App\controller;

use App\DB\DAO\Usuario as UsuarioDAO;
use App\Log\LogInterface;
use App\model\Usuario as UsuarioModel;
use App\Util\ConstantesGenericasUtil;
use App\Util\RetornoRequisicao;
use stdClass;

class Usuario extends ControllerAbstract
{

    private readonly UsuarioModel $usuarioModel;
    private readonly UsuarioDAO $usuarioDAO;

    public function __construct(object $db, LogInterface $log, UsuarioModel $usuarioModel, UsuarioDAO $usuarioDAO)
    {
        $this->usuarioModel = $usuarioModel;
        $this->usuarioDAO = $usuarioDAO;
        parent::__construct($db, $log);
    }

    public function inserir(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        return RetornoRequisicao::getInstance();
    }

    public function apagar(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        return RetornoRequisicao::getInstance();
    }

    public function alterar(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        return RetornoRequisicao::getInstance();
    }

    public function alterarParcialmente(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        return RetornoRequisicao::getInstance();
    }

    public function validarLogin(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        $retorno = RetornoRequisicao::getInstance();

        if(!is_array($dadosRecebidos) || count($dadosRecebidos) <= 0){
            $retorno->sucesso = false;
            $retorno->mensagem = ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO;
            return $retorno;
        }

        $login = isset($dadosRecebidos['login']) ? trim($dadosRecebidos['login']) : '';
        $senha = isset($dadosRecebidos['senha']) ? trim($dadosRecebidos['senha']) : '';

        $retorno = $this->usuarioDAO->validarLogin($login, $senha);

        if(!$retorno->sucesso){
            return $retorno;
        }

        $retorno->dados = json_decode($retorno->dados);

        return $this->usuarioDAO->buscarPeloID($retorno->dados->ID, ['nome','tipo']);
    }

    public function buscarTodos(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        return RetornoRequisicao::getInstance();
    }

    public function buscarPeloID(array|null $dadosRecebidos, array|null $dadosRotas, array|null $dadosHeader): stdClass
    {
        return RetornoRequisicao::getInstance();
    }
}
