<?php

namespace tests\infrastructure\log;

use App\infrastructure\log\Log;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase{

    public function testGravarLog():void{
        $log = new Log();
        unlink($log->caminho);

        $log->setMensagem('testando log');
        $log->setLocal('LogTest');
        $log->setExcecao('Excecao Testada');
        $log->setsql('SQL COM ERRO');
        $log->setDadosRecebidos('DADOS recebidos do json');

        $log->gravarLog();


        $this->assertFileExists($log->caminho);
        
        $arquivo = fopen($log->caminho, 'rb');

        $conteudo = fread($arquivo, filesize($log->caminho));

        $this->assertStringContainsString('testando log', $conteudo);
        $this->assertStringContainsString('LogTest', $conteudo);
        $this->assertStringContainsString('Excecao Testada', $conteudo);
        $this->assertStringContainsString('SQL COM ERRO', $conteudo);
        $this->assertStringContainsString('DADOS recebidos do json', $conteudo);
        
        fclose($arquivo);
    }
}