<?php

namespace tests\web\router;

use App\presentation\middlewares\MiddlewaresInterface;
use App\web\request\JsonInput;
use App\web\request\NetworkRequest;
use App\web\request\NetworkResponse;
use App\web\request\RequestType;
use App\web\router\Rota;
use App\web\router\RotaComparator;
use App\web\router\RotaData;
use App\web\router\RotaListGet;
use App\web\router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testShouldStatus404WhenRotaNotExist():void
    {
        $rota = new Rota(new RotaListGet());
        $rota->addRota(
            RequestType::GET,
            'author',
            ControllerErrorTest::class,
            'execute'
        );
        $rota->addRota(
            RequestType::POST,
            'author',
            ControllerSuccessTest::class,
            'execute'
        );
        $rotaComparator = new RotaComparator('author',RequestType::DELETE);

        $rotaData = $this->getMockBuilder(RotaData::class)->setConstructorArgs(array($rotaComparator))->getMock();
        $rotaData->method('getUri')->willReturn('author');

        $jsonInput = $this->getMockBuilder(JsonInput::class)->getMock();
        $jsonInput->method('get')->willReturn([]);


        $router = new Router($rota,$rotaComparator,$rotaData,$jsonInput);
        $response = $router->execute_uri();

        $this->assertEquals(404,$response->code);
    }

    public function testShouldReturningDataControllerError():void{
        $rota = new Rota(new RotaListGet());
        $rota->addRota(
            RequestType::GET,
            'author',
            ControllerErrorTest::class,
            'execute'
        );
        $rota->addRota(
            RequestType::POST,
            'author',
            ControllerSuccessTest::class,
            'execute'
        );
        $rotaComparator = new RotaComparator('author',RequestType::GET);

        $rotaData = $this->getMockBuilder(RotaData::class)->setConstructorArgs(array($rotaComparator))->getMock();
        $rotaData->method('getUri')->willReturn('author');

        $jsonInput = $this->getMockBuilder(JsonInput::class)->getMock();
        $jsonInput->method('get')->willReturn([]);

        $router = new Router($rota,$rotaComparator,$rotaData,$jsonInput);
        $response = $router->execute_uri();

        $this->assertEquals(ControllerErrorTest::executeResponse(), $response);
    }

    public function testShouldReturningDataControllerSuccess():void{
        $rota = new Rota(new RotaListGet());
        $rota->addRota(
            RequestType::GET,
            'author',
            ControllerErrorTest::class,
            'execute'
        );
        $rota->addRota(
            RequestType::POST,
            'author',
            ControllerSuccessTest::class,
            'execute'
        );
        $rotaComparator = new RotaComparator('author',RequestType::POST);

        $rotaData = $this->getMockBuilder(RotaData::class)->setConstructorArgs(array($rotaComparator))->getMock();
        $rotaData->method('getUri')->willReturn('author');

        $jsonInput = $this->getMockBuilder(JsonInput::class)->getMock();
        $jsonInput->method('get')->willReturn([]);

        $router = new Router($rota,$rotaComparator,$rotaData,$jsonInput);
        $response = $router->execute_uri();

        $this->assertEquals(ControllerSuccessTest::executeResponse(), $response);
    }

    public function testShouldReturningDataWithMiddlewaresErrors():void{
        $rota = new Rota(new RotaListGet());
        $rota->addRota(
            RequestType::GET,
            'author',
            ControllerErrorTest::class,
            'execute',
            middlewares_classes_names: [MiddlewaresSuccess::class,MiddlewaresSuccess::class,MiddlewaresError::class,MiddlewaresSuccess::class]
        );
        $rota->addRota(
            RequestType::POST,
            'author',
            ControllerSuccessTest::class,
            'execute'
        );
        $rotaComparator = new RotaComparator('author',RequestType::GET);

        $rotaData = $this->getMockBuilder(RotaData::class)->setConstructorArgs(array($rotaComparator))->getMock();
        $rotaData->method('getUri')->willReturn('author');

        $jsonInput = $this->getMockBuilder(JsonInput::class)->getMock();
        $jsonInput->method('get')->willReturn([]);

        $router = new Router($rota,$rotaComparator,$rotaData,$jsonInput);
        $response = $router->execute_uri();

        $this->assertEquals(MiddlewaresError::executeResponse(), $response);
    }

    public function testShouldReturningDataWithMiddlewaresSuccess():void{
        $rota = new Rota(new RotaListGet());
        $rota->addRota(
            RequestType::GET,
            'author',
            ControllerErrorTest::class,
            'execute',
            middlewares_classes_names: [MiddlewaresSuccess::class,MiddlewaresError::class]
        );
        $rota->addRota(
            RequestType::POST,
            'author',
            ControllerSuccessTest::class,
            'execute',
            middlewares_classes_names: [MiddlewaresSuccess::class]
        );
        $rotaComparator = new RotaComparator('author',RequestType::POST);

        $rotaData = $this->getMockBuilder(RotaData::class)->setConstructorArgs(array($rotaComparator))->getMock();
        $rotaData->method('getUri')->willReturn('author');

        $jsonInput = $this->getMockBuilder(JsonInput::class)->getMock();
        $jsonInput->method('get')->willReturn([]);

        $router = new Router($rota,$rotaComparator,$rotaData,$jsonInput);
        $response = $router->execute_uri();

        $this->assertEquals(ControllerSuccessTest::executeResponse(), $response);
    }
}

class ControllerErrorTest{
    public function execute(NetworkRequest $request):NetworkResponse
    {
        return self::executeResponse();
    }

    public static function executeResponse():NetworkResponse
    {
        return new NetworkResponse(400,"",[],false);
    }
}

class ControllerSuccessTest{
    public function execute(NetworkRequest $request):NetworkResponse
    {
        return self::executeResponse();
    }

    public static function executeResponse():NetworkResponse
    {
        return new NetworkResponse(200,"",[],true);
    }
}

class MiddlewaresError implements MiddlewaresInterface
{

    public function execute(NetworkRequest $networkRequest): NetworkResponse
    {
        return self::executeResponse();
    }

    public static function executeResponse():NetworkResponse
    {
        return new NetworkResponse(402,"error, not logged",[],false);
    }
}

class MiddlewaresSuccess implements MiddlewaresInterface
{

    public function execute(NetworkRequest $networkRequest): NetworkResponse
    {
        return self::executeResponse();
    }

    public static function executeResponse():NetworkResponse
    {
        return new NetworkResponse(202,"created",[],true);
    }
}