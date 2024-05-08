<?php

class CalculatorTest extends PHPUnit\Framework\TestCase
{
    public function testAddNumbers()
    {
        $calculator = new Calculator();
        $sum = $calculator->add(5, 3);

        $this->assertEquals(8, $sum);
    }
}

class Calculator
{
    public function add($number1, $number2)
    {
        return $number1 + $number2;
    }
}
