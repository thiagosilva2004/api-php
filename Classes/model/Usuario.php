<?php

namespace model;

use Exception;
use Util\ConstantesGenericasUtil;
use Log\Log;

require_once 'ModelAbstract.php';

class Usuario extends ModelAbstract{

    private int $id;
    private string $login;
    private string $senha;

    public function __construct(object $db,object $log, int $id = 0,string $login = '',string $senha = ''){
        $this->id = $id;
        $this->login = $login;
        $this->senha = $senha;
        parent::__construct('usuario', $db, $log);
    }

    public function incluir(){

    }

    public function alterar(){

    }

    /**
     * @return StdClass retornoRequisicao;
     */
    function validarLogin(){
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of senha
     */ 
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @return  self
     */ 
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }
}