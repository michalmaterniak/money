<?php

declare(strict_types = 1);

namespace Money\Currency;

readonly class Currency implements CurrencyInterface, \JsonSerializable
{
    private CurrencyInfo $currencyInfo;

    public function __construct(string $code)
    {
        $code         = strtoupper($code);
        $currencyInfo = CurrencyInfoFactory::create($code);

        if (null === $currencyInfo) {
            throw new \InvalidArgumentException("Currency `$code` does not exist.");
        }

        $this->currencyInfo = $currencyInfo;
    }

    public function getCode(): string
    {
        return $this->currencyInfo->getCode();
    }

    public function jsonSerialize(): string
    {
        return $this->getCode();
    }

    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getMajorUnit(): int
    {
        return $this->currencyInfo->getMajorUnit();
    }
}
