<?php

declare(strict_types = 1);

namespace Money\Calculator;

interface CalculatorInterface
{
    public function add(string $a, string $b): string;

    public function sub(string $a, string $b): string;

    public function times(string $a, int $b): string;

    public function percent(string $a, string $b): string;

    public function divide(string $a, int $b): string;

    public function round(string $a, int $precision): string;
}
