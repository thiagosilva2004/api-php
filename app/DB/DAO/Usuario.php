<?php

namespace App\DB\DAO;

use App\Util\ConstantesGenericasUtil;
use Exception;
use stdClass;
use App\Util\RetornoRequisicao;

final class Usuario extends DAOAbstract{

    public function __construct(object $db,object $log){
        parent::__construct('usuario', $db, $log);
    }

    public function incluir(){

    }

    public function alterar(){

    }

    /**
     * @return StdClass retornoRequisicao;
     */
    function validarLogin(string $login, string $senha): stdClass{
        $retornoRequisicao = RetornoRequisicao::getInstance();;
        try {
            if ($this->db === null){
                throw new Exception("A instancia do log nao foi passada", 1);
            } 

            if ($this->log === null){
                throw new Exception("A instancia do banco de dados nao foi passada", 1);
            } 

            if($login == ''){
                $retornoRequisicao->sucesso = false;
                $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_LOGIN_NAO_INFORMADO;
                return $retornoRequisicao;
            }

            if($senha == ''){
                $retornoRequisicao->sucesso = false;
                $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_SENHA_NAO_INFORMADO;
                return $retornoRequisicao;
            }

            $consulta = 'SELECT ID,SENHA FROM ' . $this->tabela . ' WHERE email = :email LIMIT 1';

            $stmt = $this->db->prepare($consulta);

            $stmt->bindParam(':email', $login);

            $this->log->setSql($consulta);

            $stmt->execute();

            if ($stmt->rowCount() <= 0) {
                $retornoRequisicao->sucesso = false;
                $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_LOGIN_INVALIDO;
                return $retornoRequisicao;
            }

            $registros = $stmt->fetch($this->db::FETCH_ASSOC);
            $retornoRequisicao->dados = json_encode($registros);
            
            $retornoRequisicao->sucesso = true;

            
        } catch (Exception $e) {
            $retornoRequisicao->sucesso = false;
            $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_INSPERADO;
            $this->log->setLocal($this->tabela . " validarLogin");
            $this->log->setExcecao($e->getMessage());
            $this->log->gravarLog();
        } finally {
            return $retornoRequisicao;
        }
    }
}