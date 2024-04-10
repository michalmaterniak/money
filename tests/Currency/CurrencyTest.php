<?php

namespace Test\Money\Currency;

use Money\Currency\Currency;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    use CurrencySuites;

    #[DataProvider('currencyCodes')]
    public function testCodes(Currency $currency, string $code, bool $expected): void
    {
        $this->assertSame($expected, $currency->getCode() === $code);
    }


    #[DataProvider('currencyCodes')]
    public function testJsonSerializer(Currency $currency, string $code, bool $expected): void
    {
        $this->assertSame($expected, $currency->jsonSerialize() === $code);
    }
}