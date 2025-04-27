<?php

declare(strict_types = 1);

namespace Money\Currency;

interface CurrencyInterface
{
    public function getCode(): string;
}
