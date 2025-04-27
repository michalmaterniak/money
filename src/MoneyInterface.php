<?php

declare(strict_types = 1);

namespace Money;

use Money\Currency\CurrencyInterface;

interface MoneyInterface
{
    public function getAmount(): string;

    public function getCurrencyCode(): string;

    public function getCurrency(): CurrencyInterface;

    public function equals(MoneyInterface ...$moneys): bool;

    public function identicalCurrencies(MoneyInterface ...$moneys): bool;

    public function add(MoneyInterface ...$moneys): MoneyInterface;

    public function sub(MoneyInterface ...$moneys): MoneyInterface;

    public function times(int $times): MoneyInterface;

    public function percent(float $percent): MoneyInterface;
}
