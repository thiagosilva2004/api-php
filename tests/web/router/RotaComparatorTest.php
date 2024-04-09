<?php

namespace tests\web\router;

use App\web\request\RequestType;
use App\web\router\RotaComparator;
use App\web\router\RotaSchema;
use PHPUnit\Framework\TestCase;

class RotaComparatorTest extends TestCase
{
    public function testShouldReturningTrueWhenCompareRotaEquals(): void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: "/user",
            controller_class_name: '',
            controller_function_name: 'execute'
        );

        $rotaComparator = new RotaComparator('/user', RequestType::POST);
        $this->assertTrue($rotaComparator->compare($rota));
    }

    public function testShouldReturningTrueWhenCompareRotaEqualsWithPatterns(): void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: "/user/(:numeric)",
            controller_class_name: '',
            controller_function_name: 'execute'
        );

        $rotaComparator = new RotaComparator('/user/2', RequestType::POST);
        $this->assertTrue($rotaComparator->compare($rota));
    }

    public function testShouldReturningFalseWhenCompareRotaDifferent(): void
    {
        $rota = new RotaSchema(
            requestType: RequestType::POST,
            uri: "/user",
            controller_class_name: '',
            controller_function_name: 'execute'
        );

        $rotaComparator = new RotaComparator('/user/2', RequestType::POST);
        $this->assertFalse($rotaComparator->compare($rota));
    }

    public function testShouldReturningFalseWhenCompareSameUriWithMethodDifferent(): void
    {
        $rota = new RotaSchema(
            requestType: RequestType::GET,
            uri: "/user",
            controller_class_name: '',
            controller_function_name: 'execute'
        );

        $rotaComparator = new RotaComparator('/user', RequestType::POST);
        $this->assertFalse($rotaComparator->compare($rota));
    }

}
