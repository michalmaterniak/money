<?php
declare(strict_types=1);

namespace Test\Money\Amount;

use Money\Amount\Amount;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    use AmountsSuites;

    protected Amount $amount;

    protected function setUp(): void
    {
        parent::setUp();
        $this->amount = new Amount(0);
    }

    #[DataProvider('validAmounts')]
    public function testValidAmount(mixed $number, mixed $expected): void
    {
        try {
            $obj = new Amount($number);
            $this->assertSame($expected, $obj->getAmount());
        } catch (\InvalidArgumentException) {
            $this->fail();
        }
    }

    #[DataProvider('invalidAmounts')]
    public function testInvalidAmount(mixed $number)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Amount($number);
    }

    /**
     * @param array|Amount[] $amounts
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathAmount')]
    public function testAdd(array $amounts, array $expected): void
    {
        $obj = $this->amount->add(...$amounts);
        $this->assertSame($obj->getAmount(), $expected['add']);
    }

    /**
     * @param array|Amount[] $amounts
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathAmount')]
    public function testSub(array $amounts, array $expected): void
    {
        $obj = $this->amount->sub(...$amounts);
        $this->assertSame($obj->getAmount(), $expected['sub']);
    }

    #[DataProvider('times')]
    public function testTimes(Amount $amount, int $times, Amount $expected): void
    {
        $result = $amount->times($times);

        $this->assertSame($result->getAmount(), $expected->getAmount());
    }

    /**
     * @param array|Amount[] $amounts
     * @param array $expected
     * @return void
     */
    #[DataProvider('validMathAmount')]
    public function testPercent(array $amounts, array $expected): void
    {
        foreach ($amounts as $key => $amount) {
            foreach (array_keys($expected['mul']) as $percent) {
                $this->assertSame($expected['mul'][$percent][$key], $amount->percent((float)$percent)->getAmount(), "Percent: {$percent} , Value: {$amount->getAmount()}");
            }
        }
    }
}