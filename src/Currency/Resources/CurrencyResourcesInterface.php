<?php

declare(strict_types = 1);

namespace Money\Currency\Resources;

interface CurrencyResourcesInterface
{
    public static function get(): array;
}
