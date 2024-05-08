<?php

class CalculatorTest extends PHPUnit\Framework\TestCase
{
    public function testAddNumbers(): void
    {
        $calculator = new Calculator();
        $sum = $calculator->add(5, 3);

        $this->assertEquals(8, $sum);
    }
}

class Calculator
{
    public function add(int $number1, int $number2): int
    {
        return $number1 + $number2;
    }
}
