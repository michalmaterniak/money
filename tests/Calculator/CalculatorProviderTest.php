<?php
declare(strict_types=1);

namespace Test\Money\Calculator;

use Money\Calculator\CalculatorInterface;
use Money\Calculator\Provider\CalculatorProvider;
use PHPUnit\Framework\TestCase;

class CalculatorProviderTest extends TestCase
{
    public function testMoreThanOne(): void
    {
        $calculators = CalculatorProvider::getCalculators();

        $this->assertGreaterThanOrEqual(1, count($calculators));
    }

    public function testDefaultIsAvailable()
    {
        $default = CalculatorProvider::get() ?? null;

        $this->assertTrue($default instanceof CalculatorInterface);
    }
    public function testNewCalculator(): void
    {
        $name = 'new_calc';
        $calculator = new CustomCalculator();

        CalculatorProvider::set($calculator, $name);
        $default = CalculatorProvider::get($name);

        $this->assertEquals($calculator, $default);

        $calc = CalculatorProvider::get('math');
        CalculatorProvider::set($calc, 'math');
    }
}