<?php

declare(strict_types = 1);

namespace Test\Money\Currency;

use Money\Currency\CurrencyInfo;
use Money\Currency\CurrencyInfoFactory;
use PHPUnit\Framework\TestCase;

class CurrencyInfoFactoryTest extends TestCase
{
    public function testSetCurrency()
    {
        // given
        CurrencyInfoFactory::addCurrency('TEST', 'Test Currency', 10);

        // when
        $reflection = new \ReflectionClass(CurrencyInfoFactory::class);
        $currencies = $reflection->getStaticPropertyValue('currencies');

        // then
        $this->assertArrayHasKey('TEST', $currencies);
        $this->assertEquals('Test Currency', $currencies['TEST']['name']);
        $this->assertEquals(10, $currencies['TEST']['majorUnit']);

        $currency = CurrencyInfoFactory::create('TEST');
        $this->assertInstanceOf(CurrencyInfo::class, $currency);
    }

    public function testCreateReturnsNullForUnknownCurrency()
    {
        // when
        $currency = CurrencyInfoFactory::create('UNKNOWN_CODE');

        // then
        $this->assertNull($currency);
    }

    public function testCreateReturnsValidCurrencyInfoObjectFromDefaultCurrenciesResources()
    {
        // when
        $currency = CurrencyInfoFactory::create('USD');

        // then
        $this->assertInstanceOf(CurrencyInfo::class, $currency);
        $this->assertEquals('USD', $currency->getCode());
        $this->assertEquals('US Dollar', $currency->getName());
        $this->assertEquals(2, $currency->getMajorUnit());
    }
}
