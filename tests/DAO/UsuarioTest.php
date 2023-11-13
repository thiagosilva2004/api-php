<?php

namespace tests\model;

use app\DB\DAO\Usuario;
use app\DB\DB;
use app\Log\Log;
use App\Util\ConstantesGenericasUtil;
use PHPUnit\Framework\TestCase;
use Cz\PHPUnit\MockDB\MockTrait;

class UsuarioTest extends TestCase
{

    public function testLoginNaoInformado(): void
    {
        $db = $this->getMockBuilder(DB::class)
            ->getMock();

        $log = $this->getMockBuilder(Log::class)
            ->getMock();

        $usuarioDAO = new Usuario($db, $log);
        $retorno = $usuarioDAO->validarLogin('', 'senha');

        $this->assertFalse($retorno->sucesso);
        $this->assertEquals($retorno->mensagem, ConstantesGenericasUtil::MSG_ERRO_LOGIN_NAO_INFORMADO);
    }

    public function testSenhaNaoInformado(): void
    {
        $db = $this->getMockBuilder(DB::class)
            ->getMock();

        $log = $this->getMockBuilder(Log::class)
            ->getMock();

        $usuarioModel = new Usuario($db, $log);
        $retorno = $usuarioModel->validarLogin('login', '');

        $this->assertFalse($retorno->sucesso);
        $this->assertEquals($retorno->mensagem, ConstantesGenericasUtil::MSG_ERRO_SENHA_NAO_INFORMADO);
    }

    public function testLoginInvalido(): void
    {
        /*
        $db = $this->createDatabaseMock();

        $log = $this->getMockBuilder(Log::class)
            ->getMock();

        $usuarioModel = new Usuario($db, $log);
        $retorno = $usuarioModel->validarLogin('login', 'senha');
        */
    }
}
