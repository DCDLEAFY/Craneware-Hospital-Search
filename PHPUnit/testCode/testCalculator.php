<?php
include_once './src/Calculator.php';

use PHPUnit\Framework\TestCase;

class CalculatorTests extends TestCase
{
    protected $calculator;

    protected function setUp():void
    {
        // parent::setUp();
        $this->calculator = new Calculator();
        echo 'setting up';
    }

    protected function tearDown():void
    {
        $this->calculator = NULL;
        echo "tearing down";
    }

    public function testAdd(){
        //$this->calculator = new Calculator();
        $result = $this->calculator->add(1,2);
        $this->assertEquals(3, $result);
        echo 'testing';
    }
}
