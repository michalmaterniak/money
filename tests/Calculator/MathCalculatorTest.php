<?php
declare(strict_types=1);

namespace Test\Money\Calculator;

use Money\Calculator\MathCalculator;

class MathCalculatorTest extends Calculator
{
    protected function setUp(): void
    {
        $this->calculator = new MathCalculator();
    }
}