<?php

declare(strict_types = 1);

namespace Test\Money\Calculator;

use Money\Calculator\CalculatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class Calculator extends TestCase
{
    protected CalculatorInterface $calculator;

    public static function addition(): array
    {
        return [
            ['-12', '12', '0'],
            ['-123123', '123123', '0'],
            ['999999999', '1', '1000000000'],
        ];
    }

    #[DataProvider('addition')]
    public function testAdd(string $summand1, string $summand2, string $expected)
    {
        $sum = $this->calculator->add($summand1, $summand2);

        $this->assertSame($expected, $sum);
    }

    public static function subtraction(): array
    {
        return [
            ['-12', '12', '-24'],
            ['-123123', '123123', '-246246'],
            ['999999999', '1', '999999998'],
        ];
    }

    #[DataProvider('subtraction')]
    public function testSub(string $minuend, string $subtrahend, string $expected): void
    {
        $difference = $this->calculator->sub($minuend, $subtrahend);
        $this->assertSame($expected, $difference);
    }

    public static function multiplicationRoundWithPrecision(): array
    {
        return [
            ['143342', '0.01', '1433'],
            ['143342', '0.02', '2867'],
            ['143342', '0.03', '4300'],
            ['143342', '0.04', '5734'],
            ['143342', '0.05', '7167'],
            ['143342', '0.06', '8601'],
            ['143342', '0.07', '10034'],
            ['143342', '0.08', '11467'],
            ['143342', '0.09', '12901'],
            ['143342', '0.1', '14334'],
            ['143342', '0.11', '15768'],
            ['143342', '0.12', '17201'],
            ['143342', '0.13', '18634'],
            ['143342', '0.14', '20068'],
            ['143342', '0.15', '21501'],
            ['143342', '0.16', '22935'],
            ['143342', '0.17', '24368'],
            ['143342', '0.18', '25802'],
            ['143342', '0.19', '27235'],
            ['143342', '0.2', '28668'],
            ['143342', '0.21', '30102'],
            ['143342', '0.22', '31535'],
            ['143342', '0.23', '32969'],
            ['143342', '0.24', '34402'],
            ['143342', '0.25', '35836'],
            ['143342', '0.26', '37269'],
            ['143342', '0.27', '38702'],
            ['143342', '0.28', '40136'],
            ['143342', '0.29', '41569'],
            ['143342', '0.3', '43003'],
            ['143342', '0.31', '44436'],
            ['143342', '0.32', '45869'],
            ['143342', '0.33', '47303'],
            ['143342', '0.34', '48736'],
            ['143342', '0.35', '50170'],
            ['143342', '0.36', '51603'],
            ['143342', '0.37', '53037'],
            ['143342', '0.38', '54470'],
            ['143342', '0.39', '55903'],
            ['143342', '0.4', '57337'],
            ['143342', '0.41', '58770'],
            ['143342', '0.42', '60204'],
            ['143342', '0.43', '61637'],
            ['143342', '0.44', '63070'],
            ['143342', '0.45', '64504'],
            ['143342', '0.46', '65937'],
            ['143342', '0.47', '67371'],
            ['143342', '0.48', '68804'],
            ['143342', '0.49', '70238'],
            ['143342', '0.5', '71671'],
            ['143342', '0.51', '73104'],
            ['143342', '0.52', '74538'],
            ['143342', '0.53', '75971'],
            ['143342', '0.54', '77405'],
            ['143342', '0.55', '78838'],
            ['143342', '0.56', '80272'],
            ['143342', '0.57', '81705'],
            ['143342', '0.58', '83138'],
            ['143342', '0.59', '84572'],
            ['143342', '0.6', '86005'],
            ['143342', '0.61', '87439'],
            ['143342', '0.62', '88872'],
            ['143342', '0.63', '90305'],
            ['143342', '0.64', '91739'],
            ['143342', '0.65', '93172'],
            ['143342', '0.66', '94606'],
            ['143342', '0.67', '96039'],
            ['143342', '0.68', '97473'],
            ['143342', '0.69', '98906'],
            ['143342', '0.7', '100339'],
            ['143342', '0.71', '101773'],
            ['143342', '0.72', '103206'],
            ['143342', '0.73', '104640'],
            ['143342', '0.74', '106073'],
            ['143342', '0.75', '107507'],
            ['143342', '0.76', '108940'],
            ['143342', '0.77', '110373'],
            ['143342', '0.78', '111807'],
            ['143342', '0.79', '113240'],
            ['143342', '0.8', '114674'],
            ['143342', '0.81', '116107'],
            ['143342', '0.82', '117540'],
            ['143342', '0.83', '118974'],
            ['143342', '0.84', '120407'],
            ['143342', '0.85', '121841'],
            ['143342', '0.86', '123274'],
            ['143342', '0.87', '124708'],
            ['143342', '0.88', '126141'],
            ['143342', '0.89', '127574'],
            ['143342', '0.9', '129008'],
            ['143342', '0.91', '130441'],
            ['143342', '0.92', '131875'],
            ['143342', '0.93', '133308'],
            ['143342', '0.94', '134741'],
            ['143342', '0.95', '136175'],
            ['143342', '0.96', '137608'],
            ['143342', '0.97', '139042'],
            ['143342', '0.98', '140475'],
            ['143342', '0.99', '141909'],
        ];
    }

    #[DataProvider('multiplicationRoundWithPrecision')]
    public function testMultiplicationRoundWithPrecision0(string $multiplicand, string $multiplier, string $expected): void
    {
        $product = $this->calculator->percent($multiplicand, $multiplier);

        $this->assertSame($expected, $product);
    }

    public static function times(): array
    {
        return [
            ['10', 10, '100'],
            ['0', 5, '0'],
            ['123432', 1231321, '151984413672'],
        ];
    }

    #[DataProvider('times')]
    public function testTimes(string $value, int $times, string $expected): void
    {
        $result = $this->calculator->times($value, $times);

        $this->assertSame($expected, $result);
    }

    public static function toDivideProvider(): array
    {
        return [
            ['10', 10, '1'],
            ['0', 5, '0'],
            ['123432', 123432, '1'],
            ['1000', 100, '10'],
        ];
    }

    #[DataProvider('toDivideProvider')]
    public function testDivide(string $dividend, int $divisor, string $expected): void
    {
        $result = $this->calculator->divide($dividend, $divisor);
        $this->assertSame($expected, $result);
    }

    public function testDivideByZeroShouldThrowException(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Division by zero'));
        $this->calculator->divide('100', 0);
    }

    public static function toRoundProvider(): array
    {
        return [
            ['10', 2, '10'],
            ['10', 3, '10'],
            ['123432', 1, '123432'],
            ['1000.136', 2, '1000.14'],
            ['1000.135', 2, '1000.14'],
            ['1000.134', 2, '1000.13'],
            ['23.1349999', 2, '23.13'],
        ];
    }

    #[DataProvider('toRoundProvider')]
    public function testRound(string $value, int $precision, string $expected): void
    {
        $result = $this->calculator->round($value, $precision);
        $this->assertSame($expected, $result);
    }
}
