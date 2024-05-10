<?php
declare(strict_types=1);

namespace Test\Money\Calculator;

use Money\Calculator\BCMathCalculator;
use Money\Calculator\CalculatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class Calculator extends TestCase
{
    use MathematicalSuites;

    protected CalculatorInterface $calculator;

    #[DataProvider('addition')]
    public function testAdd(string $summand1, string $summand2, string $expected)
    {
        $sum = $this->calculator->add($summand1, $summand2);

        $this->assertSame($expected, $sum);
    }

    #[DataProvider('subtraction')]
    public function testSub(string $minuend, string $subtrahend, string $expected): void
    {
        $difference = $this->calculator->sub($minuend, $subtrahend);
        $this->assertSame($expected, $difference);
    }

    #[DataProvider('multiplicationRoundWithPrecision')]
    public function testMultiplicationRoundWithPrecision0(string $multiplicand, string $multiplier, string $expected): void
    {
        $product = $this->calculator->percent($multiplicand, $multiplier);

        $this->assertSame($expected, $product);
    }

    #[DataProvider("times")]
    public function testTimes(string $value, int $times, string $expected): void
    {
        $result = $this->calculator->times($value, $times);

        $this->assertSame($expected, $result);
    }
}