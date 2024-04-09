<?php

namespace tests\web\router;

use App\web\request\RequestType;
use App\web\router\exception\ExceptionGetDataFromInvalidUri;
use App\web\router\RotaComparator;
use App\web\router\RotaData;
use App\web\router\RotaSchema;
use PHPUnit\Framework\TestCase;

class RotaDataTest extends TestCase
{
    public function testShouldTrowExceptionWhenRotaInvalid(): void
    {
        $rota = new RotaSchema(
          requestType: RequestType::POST,
          uri: '/user/(:numeric)',
          controller_class_name: '',
          controller_function_name: ''
        );
        $rotaData = new RotaData(new RotaComparator('/rota_invalid/2',RequestType::POST));

        $this->expectException(ExceptionGetDataFromInvalidUri::class);
        $rotaData->getDataRota($rota);
    }

    public function testShouldReturningEmptyArrayWhenUriDoesntHasPatterns():void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: '/user',
            controller_class_name: '',
            controller_function_name: ''
        );

        $rotaData = new RotaData(new RotaComparator('/user',RequestType::POST));
        $this->assertEquals(array(), $rotaData->getDataRota($rota));
    }

    public function testShouldReturningDataWithoutNicknames():void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: '/user/(:numeric)/(:alpha)/(:any)',
            controller_class_name: '',
            controller_function_name: ''
        );

        $dataShouldReturning = ["data_0" => 1, "data_1" => "nome", "data_2" => "maria1212"];
        $rotaData = new RotaData(new RotaComparator('/user/1/nome/maria1212',RequestType::POST));

        $this->assertEquals($dataShouldReturning, $rotaData->getDataRota($rota));
    }

    public function testShouldReturningDataWithNicknames():void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: '/user/(:numeric)/(:alpha)/(:any)',
            controller_class_name: '',
            controller_function_name: '',
            datasNicknames: ['user_id','user_filter','user_filter_data']
        );

        $dataShouldReturning = ["user_id" => 1, "user_filter" => "nome", "user_filter_data" => "maria1212"];
        $rotaData = new RotaData(new RotaComparator('/user/1/nome/maria1212',RequestType::POST));

        $this->assertEquals($dataShouldReturning, $rotaData->getDataRota($rota));
    }

    public function testShouldReturningDataWithNicknamesIncomplete():void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: '/user/(:numeric)/(:alpha)/(:any)',
            controller_class_name: '',
            controller_function_name: '',
            datasNicknames: ['user_id']
        );

        $dataShouldReturning = ["user_id" => 1, "data_1" => "nome", "data_2" => "maria1212"];
        $rotaData = new RotaData(new RotaComparator('/user/1/nome/maria1212',RequestType::POST));

        $this->assertEquals($dataShouldReturning, $rotaData->getDataRota($rota));
    }

}
