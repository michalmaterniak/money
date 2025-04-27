<?php

declare(strict_types = 1);

namespace Test\Money\Currency;

use Money\Currency\Currency;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public static function validCurrencyCodes(): array
    {
        return [
            ['USD'],
            ['PLN'],
        ];
    }

    #[DataProvider('validCurrencyCodes')]
    public function testShouldCreateCurrencyObjectSuccessfully(string $code): void
    {
        $currency = new Currency($code);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    public static function invalidCurrencyCodes(): array
    {
        return [
            ['UNKNOW_CODE'],
        ];
    }

    #[DataProvider('invalidCurrencyCodes')]
    public function testShouldThrowExceptionWhenCreatingCurrencyWithInvalidCode(string $code): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException("Currency `$code` does not exist."));
        new Currency($code);
    }
}
