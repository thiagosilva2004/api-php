<?php

namespace tests\log;

use app\Log\Log;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase{

    public function testGravarLog():void{
        unlink(__DIR__ . '\..\..\app\Log\log.txt');

        $log = new Log();
        $log->setMensagem('testando log');
        $log->setLocal('LogTest');
        $log->setExcecao('Excecao Testada');
        $log->setsql('SQL COM ERRO');
        $log->setDadosRecebidos('DADOS recebidos do json');

        $log->gravarLog();

        $this->assertFileExists(__DIR__ . '\..\..\app\Log\log.txt');
        
        $arquivo = fopen(__DIR__ . '\..\..\app\Log\log.txt', 'r');

        $conteudo = fread($arquivo, filesize(__DIR__ . '\..\..\app\Log\log.txt'));

        $this->assertStringContainsString('testando log', $conteudo);
        $this->assertStringContainsString('LogTest', $conteudo);
        $this->assertStringContainsString('Excecao Testada', $conteudo);
        $this->assertStringContainsString('SQL COM ERRO', $conteudo);
        $this->assertStringContainsString('DADOS recebidos do json', $conteudo);
        
        fclose($arquivo);
    }
}