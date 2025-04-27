<?php

declare(strict_types = 1);

namespace Test\Money;

use Money\Amount\Amount;
use Money\Currency\Currency;
use Money\Currency\CurrencyInfo;
use Money\Currency\CurrencyInfoFactory;
use Money\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    protected Money $money;

    protected function setUp(): void
    {
        $this->money = new Money(new Amount(0), new Currency('USD'));
    }

    public static function validMathMoney(): array
    {
        return [
            [
                [
                    new Money(new Amount(0), new Currency('USD')),
                    new Money(new Amount(100), new Currency('USD')),
                ],
                ['add' => '100', 'sub' => '-100', 'mul' => ['0.5' => ['0', '50'], '0.126' => ['0', '13']]],
            ],
            [
                [
                    new Money(new Amount(123), new Currency('USD')),
                    new Money(new Amount(321), new Currency('USD')),
                ],
                ['add' => '444', 'sub' => '-444', 'mul' => ['0.5' => ['62', '161'], '0.126' => ['15', '40']]],
            ],
            [
                [
                    new Money(new Amount('-100'), new Currency('USD')),
                    new Money(new Amount('100'), new Currency('USD')),
                    new Money(new Amount('50'), new Currency('USD')),
                ],
                ['add' => '50', 'sub' => '-50', 'mul' => ['0.5' => ['-50', '50', '25'], '0.126' => ['-13', '13', '6']]],
            ],
            [
                [
                    new Money(new Amount('-9999'), new Currency('USD')),
                    new Money(new Amount('-999'), new Currency('USD')),
                ],
                ['add' => '-10998', 'sub' => '10998', 'mul' => ['0.5' => ['-5000', '-500'], '0.126' => ['-1260', '-126']]],
            ],
            [
                [
                    new Money(new Amount('123311123'), new Currency('USD')),
                    new Money(new Amount('3213212312'), new Currency('USD')),
                ],
                [
                    'add' => '3336523435',
                    'sub' => '-3336523435',
                    'mul' => [
                        '0.5'   => ['61655562', '1606606156'],
                        '0.126' => ['15537201', '404864751'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array|Money[] $moneys
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathMoney')]
    public function testAdd(array $moneys, array $expected): void
    {
        $obj = $this->money->add(...$moneys);
        $this->assertSame($obj->getAmount(), $expected['add']);
    }

    /**
     * @param array|Money[] $moneys
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathMoney')]
    public function testSub(array $moneys, array $expected): void
    {
        $obj = $this->money->sub(...$moneys);
        $this->assertSame($obj->getAmount(), $expected['sub']);
    }

    public static function times(): array
    {
        return [
            [new Money(new Amount('-100'), new Currency('USD')), 5, new Money(new Amount('-500'), new Currency('USD'))],
            [new Money(new Amount('100'), new Currency('USD')), 2, new Money(new Amount('200'), new Currency('USD'))],
            [new Money(new Amount('50'), new Currency('USD')), 50, new Money(new Amount('2500'), new Currency('USD'))],
        ];
    }

    #[DataProvider('times')]
    public function testTimes(Money $money, int $times, Money $expected): void
    {
        $result = $money->times($times);

        $this->assertSame($result->getAmount(), $expected->getAmount());
        $this->assertSame($result->getCurrencyCode(), $expected->getCurrencyCode());
    }

    /**
     * @param array|Money[] $moneys
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathMoney')]
    public function testPercent(array $moneys, array $expected): void
    {
        foreach ($moneys as $key => $money) {
            foreach (array_keys($expected['mul']) as $percent) {
                $this->assertSame($expected['mul'][$percent][$key], $money->percent((float) $percent)->getAmount(), "Percent: {$percent} , Value: {$money->getAmount()}");
            }
        }
    }

    public static function identicalCurrencies(): array
    {
        return [
            [
                new Money(new Amount('0'), new Currency('EUR')),
                new Money(new Amount('1'), new Currency('EUR')),
                new Money(new Amount(1), new Currency('EUR')),
            ],
            [
                new Money(new Amount(1), new Currency('USD')),
                new Money(new Amount('4'), new Currency('USD')),
                new Money(new Amount(5), new Currency('USD')),
            ],
        ];
    }

    #[DataProvider('identicalCurrencies')]
    public function testIdenticalCurrencies(Money $source, Money ...$moneys)
    {
        $this->assertTrue($source->identicalCurrencies(...$moneys));
    }

    public static function differentCurrencies(): array
    {
        return [
            [
                new Money(new Amount('0'), new Currency('USD')), // source
                new Money(new Amount('1'), new Currency('EUR')),
                new Money(new Amount(1), new Currency('EUR')),
            ],
            [
                new Money(new Amount(1), new Currency('USD')), // source
                new Money(new Amount('4'), new Currency('USD')),
                new Money(new Amount(5), new Currency('EUR')),
            ],
        ];
    }

    #[DataProvider('differentCurrencies')]
    public function testDifferentCurrencies(Money $source, Money ...$moneys)
    {
        $this->assertFalse($source->identicalCurrencies(...$moneys));
    }

    public static function equalMoneys(): array
    {
        return [
            [
                true,
                new Money(new Amount('1'), new Currency('EUR')), // source
                new Money(new Amount('1'), new Currency('EUR')),
                new Money(new Amount(1), new Currency('EUR')),
                new Money(new Amount(1), new Currency('EUR')),
            ],
            [
                false,
                new Money(new Amount(-12), new Currency('USD')), // source
                new Money(new Amount('-12'), new Currency('USD')),
                new Money(new Amount(-12), new Currency('USD')),
                new Money(new Amount('-13'), new Currency('USD')),
            ],
            [
                false,
                new Money(new Amount(-12), new Currency('USD')), // source
                new Money(new Amount('-13'), new Currency('USD')),
                new Money(new Amount(-13), new Currency('USD')),
                new Money(new Amount('-13'), new Currency('USD')),
            ],
        ];
    }

    #[DataProvider('equalMoneys')]
    public function testEquals(bool $expected, Money $source, Money ...$moneys)
    {
        $this->assertSame($expected, $source->equals(...$moneys));
    }

    public static function currencyCodes(): array
    {
        return [
            [new Money(new Amount(-12), new Currency('USD')), 'USD', true],
            [new Money(new Amount(-12), new Currency('USD')), 'EUR', false],
        ];
    }

    #[DataProvider('currencyCodes')]
    public function testCurrencyCode(Money $source, string $code, bool $expected)
    {
        $this->assertSame($expected, $source->getCurrencyCode() === $code);
    }

    public static function invalidMathMoneyDiffrentCurrencies(): array
    {
        return [
            'usd exists' => [
                'USD',
                [
                    new Money(new Amount('123'), new Currency('USD')),
                    new Money(new Amount(321), new Currency('EUR')),
                ],
            ],
            'usd not exists' => [
                'USD',
                [
                    new Money(new Amount('123'), new Currency('PLN')),
                    new Money(new Amount(321), new Currency('EUR')),
                    new Money(new Amount(321), new Currency('USD')),
                ],
            ],
        ];
    }

    #[DataProvider('invalidMathMoneyDiffrentCurrencies')]
    public function testInvalidMathMoneyDiffrentCurrencies(string $code, array $moneys): void
    {
        $money = new Money(new Amount(100), new Currency($code));
        $this->expectExceptionObject(new \InvalidArgumentException('Currencies must be identical'));
        $money->add(...$moneys);
    }

    public function testJsonSerialize()
    {
        $money    = new Money(new Amount(12), new Currency('USD'));
        $expected = [
            'amount'   => '12',
            'currency' => 'USD',
        ];

        $this->assertSame(2, count($this->money->jsonSerialize()));
        $this->assertArrayHasKey('amount', $money->jsonSerialize());
        $this->assertArrayHasKey('currency', $money->jsonSerialize());

        foreach (array_keys($expected) as $key) {
            $this->assertSame($expected[$key], $money->jsonSerialize()[$key]);
        }
    }

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

    public static function getMoneyWithExpectedMajorUnitFormat(): array
    {
        return [
            [new Money(new Amount(1234), new Currency('USD')), '.', '', '12.34'],
            [new Money(new Amount(100), new Currency('EUR')), ',', '', '1,00'],
            [new Money(new Amount(1), new Currency('PLN')), '.', '', '0.01'],
            [new Money(new Amount(10000), new Currency('GBP')), ',', '', '100,00'],
            [new Money(new Amount(1000299), new Currency('USD')), '.', '', '10002.99'],
            [new Money(new Amount(1000299), new Currency('USD')), '.', ' ', '10 002.99'],
            [new Money(new Amount(1234), new Currency('EUR')), ',', ' ', '12,34'],
            [new Money(new Amount(1000234), new Currency('PLN')), ',', ' ', '10 002,34'],
            [new Money(new Amount(9999999), new Currency('GBP')), '.', ' ', '99 999.99'],
        ];
    }

    #[DataProvider('getMoneyWithExpectedMajorUnitFormat')]
    public function testAmountReturnsMajorUnitFormat(
        Money $money,
        string $decimalSeparator,
        string $thousandSeparator,
        string $expected,
    ): void {
        $this->assertSame($expected, $money->getMajorUnitAmount($decimalSeparator, $thousandSeparator));
    }

    public static function addCurrency(string $code, string $name, int $majorUnit): void
    {
        CurrencyInfoFactory::addCurrency($code, $name, $majorUnit);
        ;
    }

    public static function getCustomMoneyWithExpectedMajorUnitFormatWhenCustomCurrencyWithDefinedCustomUnit(): array
    {
        static::addCurrency('TEST', 'Test Currency', 5);

        return [
            [new Money(new Amount(1234567), new Currency('TEST')), '.', '', '12.34567'],
            [new Money(new Amount(10000000), new Currency('TEST')), ',', '', '100,00000'],
            [new Money(new Amount(1), new Currency('TEST')), '.', '', '0.00001'],
            [new Money(new Amount(1000000299), new Currency('TEST')), '.', ' ', '10 000.00299'],
            [new Money(new Amount(1000002999), new Currency('TEST')), ',', ' ', '10 000,02999'],
        ];
    }

    #[DataProvider('getCustomMoneyWithExpectedMajorUnitFormatWhenCustomCurrencyWithDefinedCustomUnit')]
    public function testAmountReturnsMajorUnitFormatWhenCustomMinorUnit(
        Money $money,
        string $decimalSeparator,
        string $thousandSeparator,
        string $expected,
    ): void {
        static::addCurrency('TEST', 'Test Currency', 5);

        $this->assertSame($expected, $money->getMajorUnitAmount($decimalSeparator, $thousandSeparator));
    }
}
