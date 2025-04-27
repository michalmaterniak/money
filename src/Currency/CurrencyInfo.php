<?php

declare(strict_types = 1);

namespace Money\Currency;

readonly class CurrencyInfo
{
    final public function __construct(
        private string $code,
        private string $name,
        private int $majorUnit,
    ) {}

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMajorUnit(): int
    {
        return $this->majorUnit;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
