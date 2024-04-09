<?php

namespace App\di;

use App\application\contracts\AuthorRepositoryInterface;
use App\application\useCases\AuthorUseCase;
use App\domain\repositories\AuthorRepository;
use App\infrastructure\database\contracts\AuthorRepositoryHelperDatabaseInterface;
use App\infrastructure\database\contracts\DatabaseContextInterface;
use App\infrastructure\database\contracts\DatabaseHandleExceptionInterface;
use App\infrastructure\database\contracts\DatabaseHandleOnSuccessInterface;
use App\infrastructure\database\contracts\DatabaseHandleStartStatementInterface;
use App\infrastructure\database\implemention\DatabaseContextMysql;
use App\infrastructure\database\implemention\DatabaseHandleException;
use App\infrastructure\database\implemention\DatabaseHandleOnSucesss;
use App\infrastructure\database\implemention\DatabaseHandleStartStatement;
use App\infrastructure\database\repositoryHelper\AuthorRepositoryHelperDatabase;
use App\infrastructure\log\Log;
use App\infrastructure\log\LogHandleException;
use App\infrastructure\log\LogHandleExceptionInterface;
use App\infrastructure\log\LogInterface;
use App\presentation\controller\AuthorController;
use App\web\request\RequestStatementExecute;
use App\web\token\TokenInterface;
use App\web\token\TokenJWT;
use function DI\create;
use function DI\get;

final class ContainerBuilder
{
    private static object $containerBuilder;

    public static function get(string $className):object
    {
        if(!isset(self::$containerBuilder)){
            self::$containerBuilder = self::factoryContainerBuild();
        }

        return self::$containerBuilder->get($className);
    }

    private static function factoryContainerBuild(): object
    {
        $containerBuilder = new \DI\ContainerBuilder();

        $containerBuilder->addDefinitions([
            LogInterface::class => create(Log::class)->constructor(),

            TokenInterface::class => create(TokenJWT::class)
                ->constructor($_ENV['CHAVE_JWT'], $_ENV['ISS'], $_ENV['AUD']),

            LogHandleExceptionInterface::class =>
                create(LogHandleException::class)
                    ->constructor(get(LogInterface::class)),

            DatabaseContextInterface::class =>
                create(DatabaseContextMysql::class)
                    ->constructor(),

            DatabaseHandleExceptionInterface::class =>
                create(DatabaseHandleException::class)
                    ->constructor(get(DatabaseContextInterface::class)),

            DatabaseHandleOnSuccessInterface::class =>
                create(DatabaseHandleOnSucesss::class)
                    ->constructor(get(DatabaseContextInterface::class)),

            DatabaseHandleStartStatementInterface::class =>
                create(DatabaseHandleStartStatement::class)
                    ->constructor(get(DatabaseContextInterface::class)),

            RequestStatementExecute::class =>
                create(RequestStatementExecute::class)
                    ->constructor(
                        get(LogHandleExceptionInterface::class),
                        get(DatabaseHandleExceptionInterface::class),
                        get(DatabaseHandleOnSuccessInterface::class),
                        get(DatabaseHandleStartStatementInterface::class),
                    ),

            AuthorRepositoryHelperDatabaseInterface::class =>
                create(AuthorRepositoryHelperDatabase::class)
                    ->constructor(get(DatabaseContextInterface::class)),

            AuthorRepositoryInterface::class =>
                create(AuthorRepository::class)
                    ->constructor(get(AuthorRepositoryHelperDatabaseInterface::class)),

            AuthorUseCase::class =>
                create(AuthorUseCase::class)
                    ->constructor(get(AuthorRepositoryInterface::class)),

            AuthorController::class =>
                create(AuthorController::class)
                    ->constructor(get(AuthorUseCase::class))
        ]);

        return $containerBuilder->build();
    }
}
