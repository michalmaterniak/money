<?php
declare(strict_types=1);

namespace Money\Calculator\Provider;

use Money\Calculator\BcmathCalculator;
use Money\Calculator\CalculatorInterface;

abstract class CalculatorProvider extends Calculators
{
    private static string $default = 'math';

    public static function get(string $name = null): CalculatorInterface
    {
        $name = $name ?? static::$default;

        if (array_key_exists($name, static::getCalculators())) {
            return static::$calculators[$name];
        }

        return self::$calculators[self::$default];
    }

    public static function set(CalculatorInterface $default, string $key): void
    {
        parent::set($default, $key);
        self::$default = $key;
    }
}