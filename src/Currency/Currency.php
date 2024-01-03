<?php
declare(strict_types=1);

namespace Money\Currency;

readonly class Currency implements CurrencyInterface, \JsonSerializable
{
    protected string $code;

    public function __construct(string $code)
    {
        $this->code = strtoupper($code);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function jsonSerialize(): mixed
    {
        return $this->code;
    }
}