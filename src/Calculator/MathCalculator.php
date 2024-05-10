<?php
declare(strict_types=1);

namespace Money\Calculator;

class MathCalculator implements CalculatorInterface
{
    public function add(string $a, string $b): string
    {
        return (string)((int)$a + (int)$b);
    }

    public function sub(string $a, string $b): string
    {
        return (string)((int)$a - (int)$b);
    }

    public function times(string $a, int $b): string
    {
        return (string)((int)$a * $b);
    }

    public function percent(string $a, string $b): string
    {
        return (string)(round((int)$a * (float)$b));
    }
}