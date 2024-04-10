<?php

namespace Test\Money\Currency;

use Money\Currency\Currency;

trait CurrencySuites
{
    public static function currencyCodes()
    {
        return [
          [new Currency('USD'), 'USD', true],
          [new Currency('USD'), 'EUR', false],
        ];
    }
}