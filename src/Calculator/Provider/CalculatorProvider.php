<?php

declare(strict_types = 1);

namespace Money\Calculator\Provider;

use Money\Calculator\CalculatorInterface;

abstract class CalculatorProvider extends Calculators
{
    private static string $default = 'math';

    public static function get(string|null $name = null): CalculatorInterface
    {
        $name ??= static::$default;

        if (array_key_exists($name, static::getCalculators())) {
            return static::$calculators[$name];
        }

        return static::$calculators[static::$default];
    }

    public static function set(CalculatorInterface $default, string $key): void
    {
        parent::set($default, $key);
        static::$default = $key;
    }
}
