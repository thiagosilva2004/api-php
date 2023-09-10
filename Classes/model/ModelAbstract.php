<?php

namespace model;

use Exception;
use Util\ConstantesGenericasUtil;
use DB\DB;
use Log\LogInterface;

require_once __DIR__ . '/../DB/DB.php';
require_once __DIR__ . '/../Util/retornoRequisicao.php';

abstract class ModelAbstract
{

    protected string $tabela;
    protected object $db;
    protected object $log;

    public function __construct(string $tabela, object $db,LogInterface $log)
    {
        $this->tabela = $tabela;
        $this->db = $db;
        $this->log = $log;
    }

    /**
     * @param integer $id
     * @return StdClass retornoRequisicao;
     */
    public function apagar(int $id)
    {
        $retornoRequisicao = GetInstanceRetornoRequisicao();
        try {
            if ($this->db === null){
                throw new Exception("A instancia do log nao foi passada", 1);
            } 

            if ($this->log === null){
                throw new Exception("A instancia do banco de dados nao foi passada", 1);
            } 

            if ($id < 0) {
                throw new Exception("o id informado não é válido", 1);
            }

            $consulta = 'DELETE FROM ' . $this->tabela . ' WHERE id = :id LIMIT 1';

            $stmt = $this->db->prepare($consulta);

            $stmt->bindParam(':id', $id);

            $this->log->setSql($consulta);

            $stmt->execute();

            if ($stmt->rowCount() <= 0) {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO, 1);
            }

            $retornoRequisicao->sucesso = true;
            $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_DELETADO_SUCESSO;
        } catch (Exception $e) {
            $retornoRequisicao->sucesso = false;
            $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_INSPERADO;
            $this->log->setLocal($this->tabela . " Apagar");
            $this->log->setExcecao($e->getMessage());
            $this->log->gravarLog();
        } finally {
            return $retornoRequisicao;
        }
    }

    /**
     * @param integer $paginacao_quantidade
     * @param integer $paginacao_indice
     * @return StdClass retornoRequisicao;
     */
    public function BuscarTodos(int $paginacao_quantidade = 0,int $paginacao_indice = 0)
    {
        $retornoRequisicao = GetInstanceRetornoRequisicao();
        try {
            if ($this->db === null){
                throw new Exception("A instancia do log nao foi passada", 1);
            } 

            if ($this->log === null){
                throw new Exception("A instancia do banco de dados nao foi passada", 1);
            } 

            $consulta = 'SELECT * FROM ' . $this->tabela;

            $this->log->setSql($consulta);

            $stmt = $this->db->query($consulta);
            $registros = $stmt->fetchAll($this->db::FETCH_ASSOC);

            if (is_array($registros) && count($registros) > 0) {
                $retornoRequisicao->dados = json_encode($registros);
            } else {
                $retornoRequisicao->dados = '{' . $this->tabela . ' : [] }';
            }

            $retornoRequisicao->sucesso = true;
        } catch (Exception $e) {
            $retornoRequisicao->sucesso = false;
            $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_INSPERADO;
            $this->log->setLocal($this->tabela . " BuscarTodos");
            $this->log->setExcecao($e->getMessage());
            $this->log->gravarLog();
        } finally {
           return $retornoRequisicao;
        }
    }

    /**
     * @param integer $id
     * @return StdClass retornoRequisicao;
     */
    public function BuscarPeloID(int $id)
    {
        $retornoRequisicao = GetInstanceRetornoRequisicao();
        try {
            if ($this->db === null){
                throw new Exception("A instancia do log nao foi passada", 1);
            } 

            if ($this->log === null){
                throw new Exception("A instancia do banco de dados nao foi passada", 1);
            } 

            if ($id < 0) {
                throw new Exception("o id informado não é válido", 1);
            }

            $consulta = 'SELECT * FROM ' . $this->tabela . ' WHERE id = :id';

            $stmt = $this->db->prepare($consulta);
            $stmt->bindParam(':id', $id);

            $this->log->setSql($consulta);

            $stmt->execute();

            $totalRegistros = $stmt->rowCount();
            if ($totalRegistros === 1) {
                $registros = $stmt->fetch($this->db::FETCH_ASSOC);
                $retornoRequisicao->dados = json_encode($registros);
            } else {
                $retornoRequisicao->dados = '{' . $this->tabela . ' : [] }';
            }

            $retornoRequisicao->sucesso = true;
        } catch (Exception $e) {
            $retornoRequisicao->sucesso = false;
            $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_INSPERADO;
            $this->log->setLocal($this->tabela . " BuscarPeloID");
            $this->log->setExcecao($e->getMessage());
            $this->log->gravarLog();
        } finally {
            return $retornoRequisicao;
        }
    }

    /**
     * @param integer id
     * @param StdClass [coluna,valor] dados
     * @return StdClass retornoRequisicao;
     */
    public function alterarParcialmente(int $id,array $dados)
    {
        $retornoRequisicao = GetInstanceRetornoRequisicao();
        try {
            if ($this->db === null){
                throw new Exception("A instancia do log nao foi passada", 1);
            } 

            if ($this->log === null){
                throw new Exception("A instancia do banco de dados nao foi passada", 1);
            } 

            if ($id < 0) {
                throw new Exception("o id informado não é válido", 1);
            }

            if(count($dados) <= 0){
                throw new Exception("nenhum dados informado para alteracao", 1);
            }

            $consulta = 'UPDATE ' . $this->tabela . ' SET ';

            foreach($dados as $dado){
                $consulta = $consulta . ' ' . $dado->coluna . ' = :' . $dado->coluna . ' ';   
            }

            $consulta = $consulta . ' WHERE id = :id LIMIT 1';

            $stmt = $this->db->prepare($consulta);
            $stmt->bindParam(':id', $id);

            foreach($dados as $dado){
                $stmt->bindParam(':' . $dado->coluna, $dado->valor);
            }

            $this->log->setSql($consulta);

            $stmt->execute();

            $totalRegistros = $stmt->rowCount();
            if ($totalRegistros === 1) {
                $registros = $stmt->fetch($this->db::FETCH_ASSOC);
                $retornoRequisicao->dados = json_encode($registros);
            } else {
                $retornoRequisicao->dados = '{' . $this->tabela . ' : [] }';
            }

            $retornoRequisicao->sucesso = true;
        } catch (Exception $e) {
            $retornoRequisicao->sucesso = false;
            $retornoRequisicao->mensagem = ConstantesGenericasUtil::MSG_ERRO_INSPERADO;

            $this->log->setLocal($this->tabela . ' alterarParcialmente');
            $this->log->setExcecao($e->getMessage());
            $this->log->gravarLog();
        } finally {
            return $retornoRequisicao;
        }
    }

    /**
     * Get the value of db
     */ 
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Set the value of db
     *
     * @return  self
     */ 
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }
}
