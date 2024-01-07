<?php

namespace App\Util;

use App\controller\Usuario as UsuarioController;
use App\DB\DAO\Usuario as UsuarioDAO;
use App\DB\DB;
use App\Log\Log;
use App\Log\LogInterface;
use App\model\Usuario as UsuarioModel;
use App\router\middlewares\ValidarToken;
use App\Util\token\TokenInterface;
use App\Util\token\TokenJWT;

final class ContainerBuilder
{
    public static function getInstance(): object
    {
        $db = DB::getInstance();
        $log = new Log();
        $containerBuilder = new \DI\ContainerBuilder();

        $containerBuilder->addDefinitions([
            UsuarioDAO::class => \DI\create(UsuarioDAO::class)->constructor($db, $log),
            LogInterface::class => \DI\create(Log::class)->constructor(),
            UsuarioController::class => \DI\create(UsuarioController::class)->constructor(
                DB::getInstance(),
                \DI\get('App\Log\LogInterface'),
                new UsuarioModel(),
                \DI\get('App\DB\DAO\Usuario'),
            ),
            TokenInterface::class => \DI\create(TokenJWT::class)->constructor($_ENV['CHAVE_JWT'], $_ENV['ISS'], $_ENV['AUD']),
            ValidarToken::class => \DI\create(ValidarToken::class)->constructor(\DI\get('App\Util\token\TokenInterface')),
        ]);

        return $containerBuilder->build();
    }
}
