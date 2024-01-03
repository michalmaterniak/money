<?php
declare(strict_types=1);

namespace Test\Money\Amount;

use Money\Amount\Amount;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    use AmountsSuites;

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
}