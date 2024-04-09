<?php

namespace App\infrastructure\log;

use DateTime;
use DateTimeZone;

class Log implements LogInterface
{
    public readonly string $caminho;
    private string $mensagem = '';
    private string $local = '';
    private string $excecao = '';
    private string $sql = '';
    private string $dadosRecebidos = '';

    public function __construct()
    {
        $this->caminho = __DIR__ . DIRECTORY_SEPARATOR . 'log.txt';
    }

    public function gravarLog():void{
        $data = new DateTime();  
        $data->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $dataHora = $data->format("d-m-Y h:i:s a");  

        $texto = 'mensagem: ' . $this->mensagem . 
                 ' data e hora: ' .  $dataHora . 
                 ' local: ' . $this->local . 
                 ' excecao: ' . $this->excecao . 
                 ' sql: ' . $this->sql . 
                 ' dados recebidos: ' . $this->dadosRecebidos . 
                 PHP_EOL;

        file_put_contents($this->caminho, $texto, FILE_APPEND);
    }

    public function getDadosRecebidos():string
    {
        return $this->dadosRecebidos;
    }
    public function setDadosRecebidos(string $dadosRecebidos):void
    {
        $this->dadosRecebidos = $dadosRecebidos;
    }

    public function getMensagem():string
    {
        return $this->mensagem;
    }
    public function setMensagem($mensagem):void
    {
        $this->mensagem = $mensagem;
    }

    public function getLocal():string
    {
        return $this->local;
    }
    public function setLocal($local):void
    {
        $this->local = $local;
    }

    public function getExcecao():string
    {
        return $this->excecao;
    }
    public function setExcecao($excecao):void
    {
        $this->excecao = $excecao;
    }

    public function getSql():string
    {
        return $this->sql;
    }
    public function setSql($sql):void
    {
        $this->sql = $sql;
    }
}
