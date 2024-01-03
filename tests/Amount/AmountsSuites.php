<?php
declare(strict_types=1);

namespace Test\Money\Amount;

trait AmountsSuites
{
    public static function validAmounts(): array
    {
        return [
            ["0", "0"],
            ["-12", "-12"],
            ["12", "12"],
            ["1231232131231313", "1231232131231313"],
            [123123, "123123"],
            [-12312, "-12312"],
        ];
    }

    public static function invalidAmounts(): array
    {
        return [
            [' '],
            [' 0'],
            [1.1],
            [-1.2],
            ['0.123'],
            ['asdf'],
            ['-1.321'],
            ["-1 "],
            ["-0"],
            [-1.12],
            ['123.20'],
            ['1233234234378789547392457983534957834858v'],
        ];
    }
}
