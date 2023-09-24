<?php

namespace tests\token;

use app\Util\token\TokenJWT;
use PHPUnit\Framework\TestCase;

class TokenJWTTest extends TestCase
{

    private string $chave = '123456';

    public function testGerarTokenVazio():void
    {
        $tokenJWT = new TokenJWT($this->chave, 'localhost', 'localhost');
        $token = $tokenJWT->gerarToken();

        $this->assertEquals(substr_count($token, '.'), 2);
    }

    public function testValidarTokenVazio():void
    {
        $tokenJWT = new TokenJWT($this->chave, 'localhost', 'localhost');
        $token = $tokenJWT->gerarToken();

        $this->assertTrue($tokenJWT->validarToken($token));
    }

    public function testValidarDadosTokenVazio():void
    {
        $duracaoComeco = time() + 6048000;

        $tokenJWT = new TokenJWT($this->chave, 'www.aplicativo.com.br', 'www.api.com.br', duracao:6048000);
        $token = $tokenJWT->gerarToken();


        $payload = $tokenJWT->getPayload($token);
        
        $this->assertEquals($payload->iss, 'www.aplicativo.com.br');
        $this->assertEquals($payload->aud, 'www.api.com.br');
        $this->assertGreaterThanOrEqual($payload->exp, $duracaoComeco);
        $this->assertCount(0, $payload->dados);
    }

    public function testValidarDadosTokenComDados():void
    {
        $duracaoComeco = time() + 6048000;
        $dados = array(['email' => 'teste@gmail.com', 'id' => '1444', 'nome' => 'thiago']);

        $tokenJWT = new TokenJWT($this->chave, 'www.aplicativo.com.br', 'www.api.com.br', duracao:6048000);
        $token = $tokenJWT->gerarToken($dados);

        $payload = $tokenJWT->getPayload($token);
        
        $this->assertEquals($payload->iss, 'www.aplicativo.com.br');
        $this->assertEquals($payload->aud, 'www.api.com.br');
        $this->assertGreaterThanOrEqual($payload->exp, $duracaoComeco);
        $this->assertEquals($dados[0]['email'], $payload->dados[0]->email);
        $this->assertEquals($dados[0]['id'], $payload->dados[0]->id);
        $this->assertEquals($dados[0]['nome'], $payload->dados[0]->nome);
    }

    public function testValidarTokenChavesDiferentes():void{
        $tokenJWTChave123 = new TokenJWT('123','localhost', 'localhost');
        $tokenChave123 = $tokenJWTChave123->gerarToken();

        $tokenJWTChave321 = new TokenJWT('321','localhost', 'localhost');
        $tokenChave321 = $tokenJWTChave321->gerarToken();

        $this->assertFalse($tokenJWTChave123->validarToken($tokenChave321));
        $this->assertFalse($tokenJWTChave321->validarToken($tokenChave123));
    }

    public function testValidarTokenTempoInvalido():void{
        $tokenJWT = new TokenJWT($this->chave,'localhost', 'localhost', duracao: 1);
        $token = $tokenJWT->gerarToken();

        sleep(3);

        $this->assertFalse($tokenJWT->validarToken($token));
    }

    public function testGetDados():void{
        $duracaoComeco = time() + 6048000;
        $dados = array(['email' => 'teste@gmail.com', 'id' => '1444', 'nome' => 'thiago']);

        $tokenJWT = new TokenJWT($this->chave, 'www.aplicativo.com.br', 'www.api.com.br', duracao:6048000);
        $token = $tokenJWT->gerarToken($dados);

        $this->assertEquals($tokenJWT->getDados($token, 'email'), $dados[0]['email']);
        $this->assertEquals($tokenJWT->getDados($token, 'id'), $dados[0]['id']);
        $this->assertEquals($tokenJWT->getDados($token, 'nome'), $dados[0]['nome']);
    }
}
