<?php

namespace tests\web\request;

use App\web\request\JsonInput;
use App\web\request\NetworkRequest;
use App\web\request\RequestType;
use App\web\router\RotaComparator;
use App\web\router\RotaData;
use PHPUnit\Framework\TestCase;

class NetworkRequestTest extends TestCase
{

    private NetworkRequest $networkRequest;

    public function createRequireMocks(bool $createWithData): void
    {
        $jsonInput = $this->getMockBuilder(className: JsonInput::class)->getMock();
        $jsonInput->method('get')->willReturn(
            $createWithData ?
                [
                    "name" => "james",
                    "age" => 25,
                    "doc" => "",
                    "salary" => 2123.78
                ]
            : []
        );

        $rotaData = $this->getMockBuilder(className: RotaData::class)
                            ->setConstructorArgs(array(new RotaComparator('user/',RequestType::POST)))
                            ->getMock();
        $rotaData->method('getHeaderInput')->willReturn(
            $createWithData ?
                [
                    "name" => "james",
                    "age" => 25,
                    "doc" => "",
                    "salary" => 2123.78
                ]
            : []
        );

        $router_data = $createWithData ? ["user_id" => 5, "user_name" => "fake_name", "user_doc" => ""] : array();

        $this->networkRequest = new NetworkRequest(
            $jsonInput,
            $rotaData,
            $router_data
        );
    }

    public function test_getBodyDataFieldAsString_shouldReturningDataWhenExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals("james",$this->networkRequest->getBodyDataFieldAsString("name") );
    }

    public function test_getBodyDataFieldAsString_shouldReturningDataWhenEmpty():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals("",$this->networkRequest->getBodyDataFieldAsString("doc") );
    }

    public function test_getBodyDataFieldAsString_shouldReturningEmptyWhenNotExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals("",$this->networkRequest->getBodyDataFieldAsString("not_exist"));
    }

    public function test_getBodyDataFieldAsString_shouldReturningEmptyWhenArrayNotExist():void
    {
        $this->createRequireMocks(false);
        $this->assertEquals("",$this->networkRequest->getBodyDataFieldAsString("name"));
    }

    public function test_getBodyDataFieldAsStringNull_shouldReturningDataWhenExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals("james",$this->networkRequest->getBodyDataFieldAsStringNull("name") );
    }

    public function test_getBodyDataFieldAsStringNull_shouldReturningNullWhenIsEmpty():void
    {
        $this->createRequireMocks(true);
        $this->assertNull($this->networkRequest->getBodyDataFieldAsStringNull("doc"));
    }

    public function test_getBodyDataFieldAsString_shouldReturningNullWhenNotExist():void
    {
        $this->createRequireMocks(true);
        $this->assertNull($this->networkRequest->getBodyDataFieldAsStringNull("not_exist"));
    }

    public function test_getBodyDataFieldAsString_shouldReturningNullWhenArrayNotExist():void
    {
        $this->createRequireMocks(false);
        $this->assertNull($this->networkRequest->getBodyDataFieldAsStringNull("name"));
    }

    public function test_getBodyDataFieldAsInt_shouldReturningDataWhenExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals(25,$this->networkRequest->getBodyDataFieldAsInt("age"));
    }

    public function test_getBodyDataFieldAsInt_shouldReturningOneNegativeWhenIsEmpty():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals(-1,$this->networkRequest->getBodyDataFieldAsInt("doc"));
    }

    public function test_getBodyDataFieldAsInt_shouldReturningOneNegativeWhenNotExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals(-1,$this->networkRequest->getBodyDataFieldAsInt("not_exist"));
    }

    public function test_getBodyDataFieldAsInt_shouldReturningOneNegativeWhenArrayNotExist():void
    {
        $this->createRequireMocks(false);
        $this->assertEquals(-1,$this->networkRequest->getBodyDataFieldAsInt("age"));
    }

    public function test_getRouterDataFieldAsInt_shouldReturningDataWhenExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals(5,$this->networkRequest->getRouterDataFieldAsInt("user_id"));
    }

    public function test_getRouterDataFieldAsInt_shouldReturningOneNegativeWhenIsEmpty():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals(-1,$this->networkRequest->getRouterDataFieldAsInt("user_doc"));
    }

    public function test_getRouterDataFieldAsInt_shouldReturningOneNegativeWhenNotExist():void
    {
        $this->createRequireMocks(true);
        $this->assertEquals(-1,$this->networkRequest->getRouterDataFieldAsInt("not_exist"));
    }

    public function test_getRouterDataFieldAsInt_shouldReturningOneNegativeWhenArrayNotExist():void
    {
        $this->createRequireMocks(false);
        $this->assertEquals(-1,$this->networkRequest->getRouterDataFieldAsInt("user_id"));
    }
}
