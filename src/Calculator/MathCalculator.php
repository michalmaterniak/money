<?php

declare(strict_types = 1);

namespace Money\Calculator;

class MathCalculator implements CalculatorInterface
{
    public function add(string $a, string $b): string
    {
        return (string) ((int) $a + (int) $b);
    }

    public function sub(string $a, string $b): string
    {
        return (string) ((int) $a - (int) $b);
    }

    public function times(string $a, int $b): string
    {
        return (string) ((int) $a * $b);
    }

    public function percent(string $a, string $b): string
    {
        return (string) (round((int) $a * (float) $b));
    }

    public function divide(string $a, int $b): string
    {
        if ($b === 0) {
            throw new \InvalidArgumentException('Division by zero');
        }

        return (string) ((int) $a / $b);
    }

    public function round(string $a, int $precision): string
    {
        return (string) round(floatval($a), $precision, PHP_ROUND_HALF_UP);
    }
}
