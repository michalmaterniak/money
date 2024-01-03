<?php
declare(strict_types=1);

namespace Money\Calculator\Provider;

use Money\Calculator\MathCalculator;
use Money\Calculator\CalculatorInterface;

/**
 * @internal
 */
abstract class Calculators
{
    private static array $classess = ['math' => MathCalculator::class];
    protected static array $calculators = [];

    private static function init(): void
    {
        foreach (self::$classess as $name => $class) {
            static::set(new $class, $name);
        }
    }

    public static function set(CalculatorInterface $calculator, string $name): void
    {
        static::$calculators[$name] = $calculator;
    }

    public static function getCalculators(): array
    {
        if (!static::$calculators) {
            static::init();
        }

        return static::$calculators;
    }
}