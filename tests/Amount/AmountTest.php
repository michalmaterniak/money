<?php

declare(strict_types = 1);

namespace Test\Money\Amount;

use Money\Amount\Amount;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    protected Amount $amount;

    protected function setUp(): void
    {
        parent::setUp();
        $this->amount = new Amount(0);
    }

    public static function validAmounts(): array
    {
        return [
            ['0', '0'],
            ['-12', '-12'],
            ['12', '12'],
            ['1231232131231313', '1231232131231313'],
            [123123, '123123'],
            [-12312, '-12312'],
        ];
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

    public static function invalidAmounts(): array
    {
        return [
            [' '],
            [' 0'],
            ['0.123'],
            ['asdf'],
            ['-1.321'],
            ['-1 '],
            ['-0'],
            ['123.20'],
            ['1233234234378789547392457983534957834858v'],
        ];
    }

    #[DataProvider('invalidAmounts')]
    public function testInvalidAmount(mixed $number)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Amount($number);
    }

    public static function validMathAmount(): array
    {
        return [
            [
                [
                    new Amount(0),
                    new Amount(100),
                ],
                ['add' => '100', 'sub' => '-100', 'mul' => ['0.5' => ['0', '50'], '0.126' => ['0', '13']]],
            ],
            [
                [
                    new Amount(123),
                    new Amount(321),
                ],
                ['add' => '444', 'sub' => '-444', 'mul' => ['0.5' => ['62', '161'], '0.126' => ['15', '40']]],
            ],
            [
                [
                    new Amount('-100'),
                    new Amount('100'),
                    new Amount('50'),
                ],
                ['add' => '50', 'sub' => '-50', 'mul' => ['0.5' => ['-50', '50', '25'], '0.126' => ['-13', '13', '6']]],
            ],
            [
                [
                    new Amount('-9999'),
                    new Amount('-999'),
                ],
                ['add' => '-10998', 'sub' => '10998', 'mul' => ['0.5' => ['-5000', '-500'], '0.126' => ['-1260', '-126']]],
            ],
            [
                [
                    new Amount('123311123'),
                    new Amount('3213212312'),
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

    public static function times(): array
    {
        return [
            [new Amount('-100'), 5, new Amount('-500')],
            [new Amount('100'), 2, new Amount('200')],
            [new Amount('50'), 50, new Amount('2500')],
        ];
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
                $this->assertSame($expected['mul'][$percent][$key], $amount->percent((float) $percent)->getAmount(), "Percent: {$percent} , Value: {$amount->getAmount()}");
            }
        }
    }
}
