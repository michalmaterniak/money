<?php
declare(strict_types=1);

namespace Test\Money;

use Money\Amount\Amount;
use Money\Calculator\Provider\CalculatorProvider;
use Money\Currency\Currency;
use Money\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    use MoneySuites;

    protected Money $money;

    protected function setUp(): void
    {
        $this->money = new Money(new Amount(0), new Currency('USD'));
    }

    /**
     * @param array|Money[] $money
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathMoney')]
    public function testAdd(array $money, array $expected): void
    {
        $obj = $this->money->add(...$money);
        $this->assertSame($obj->getAmount(), $expected['add']);
    }

    /**
     * @param array|Money[] $money
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathMoney')]
    public function testSub(array $money, array $expected): void
    {
        $obj = $this->money->add(...$money);
        $this->assertSame($obj->getAmount(), $expected['add']);
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
                $this->assertSame($expected['mul'][$percent][$key], $money->percent((float)$percent)->getAmount(), "Percent: {$percent} , Value: {$money->getAmount()}");
            }
        }
    }

    #[DataProvider('identicalCurrencies')]
    public function testIdenticalCurrencies(Money $source, Money ...$moneys)
    {
        $this->assertTrue($source->identicalCurrencies(...$moneys));
    }

    #[DataProvider('differentCurrencies')]
    public function testDifferentCurrencies(Money $source, Money ...$moneys)
    {
        $this->assertFalse($source->identicalCurrencies(...$moneys));
    }

    #[DataProvider('equalMoneys')]
    public function testEquals(bool $expected, Money $source, Money ...$moneys)
    {
        $this->assertSame($expected, $source->equals(...$moneys));
    }

    #[DataProvider('currencyCodes')]
    public function testCurrencyCode(Money $source, string $code, bool $expected)
    {
        $this->assertSame($expected, $source->getCurrencyCode() === $code);
    }

    public function testJsonSerialize()
    {
        $money = new Money(new Amount(12), new Currency('USD'));
        $expected = [
            'amount' => '12',
            'currency' => 'USD'
        ];

        $this->assertSame(2, count($this->money->jsonSerialize()));
        $this->assertArrayHasKey('amount', $money->jsonSerialize());
        $this->assertArrayHasKey('currency', $money->jsonSerialize());

        foreach (array_keys($expected) as $key) {
            $this->assertSame($expected[$key], $money->jsonSerialize()[$key]);
        }
    }
}