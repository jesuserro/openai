<?php

namespace Tests\Cdr;

use Cdr\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAddNumbers(): void
    {
        $calculator = new Calculator();
        $sum = $calculator->add(5, 3);

        $this->assertEquals(8, $sum);
    }

    public function testMultiplyNumbers(): void
    {
        $calculator = new Calculator();
        $sum = $calculator->multiply(5, 3);

        $this->assertEquals(15, $sum);
    }
}
