<?php

namespace tests\domain\valueObject;

use App\domain\valueObjects\CPF;
use PHPUnit\Framework\TestCase;

class CPFTest extends TestCase
{

    public function testShouldReturningCPFInvalidWhenLonger11Digits():void
    {
        $this->assertFalse(CPF::validate(''));
        $this->assertFalse(CPF::validate('15445'));
        $this->assertFalse(CPF::validate('15445445454545454554'));
        $this->assertFalse(CPF::validate('154454454545454sdsds'));
    }

    public function testShouldReturningCPFInvalid():void{
        $this->assertFalse(CPF::validate('12345678911'));
        $this->assertFalse(CPF::validate('12121164446'));
        $this->assertFalse(CPF::validate('021.212.211-21'));
    }

    public function testShouldReturningCPFValid():void{
        $this->assertTrue(CPF::validate('67600869292'));
        $this->assertTrue(CPF::validate('16652573342'));
        $this->assertTrue(CPF::validate('58917476694'));
    }

    public function testConstructShouldReturningFalse():void
    {
        $this->assertFalse(CPF::create(''));
        $this->assertFalse(CPF::create('15445'));
        $this->assertFalse(CPF::create('15445445454545454554'));
        $this->assertFalse(CPF::create('12345678911'));
        $this->assertFalse(CPF::create('12121164446'));
        $this->assertFalse(CPF::create('021.212.211-21'));
    }

    public function testConstructShouldReturningCPFInstance():void
    {
        $this->assertIsObject(CPF::create('67600869292'));
        $this->assertIsObject(CPF::create('16652573342'));
        $this->assertIsObject(CPF::create('58917476694'));
    }
}
