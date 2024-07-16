<?php
declare(strict_types=1);

namespace Test\Money\Amount;

use Money\Amount\Amount;

trait AmountsSuites
{
    public static function validMathAmount(): array
    {
        return [
            [
                [
                    new Amount(0),
                    new Amount(100),
                ],
                ['add' => "100", 'sub' => '-100', 'mul' => ['0.5' => ["0", "50"], "0.126" => ["0", "13"]]],
            ],
            [
                [
                    new Amount(123),
                    new Amount(321),
                ],
                ['add' => "444", 'sub' => '-444', 'mul' => ['0.5' => ["62", "161"], "0.126" => ["15", "40"]]],
            ],
            [
                [
                    new Amount('-100'),
                    new Amount('100'),
                    new Amount('50'),
                ],
                ['add' => "50", 'sub' => '-50', 'mul' => ['0.5' => ["-50", "50", "25"], "0.126" => ["-13", "13", "6"]]],
            ],
            [
                [
                    new Amount('-9999'),
                    new Amount('-999'),
                ],
                ['add' => "-10998", 'sub' => '10998', 'mul' => ['0.5' => ["-5000", "-500"], "0.126" => ["-1260", "-126"]]],
            ],
            [
                [
                    new Amount('123311123'),
                    new Amount('3213212312'),
                ],
                [
                    'add' => "3336523435",
                    'sub' => '-3336523435',
                    'mul' => [
                        '0.5' => ["61655562", "1606606156"],
                        "0.126" => ["15537201", "404864751"]
                    ]
                ],
            ]
        ];
    }

    public static function times(): array
    {
        return [
            [new Amount('-100'), 5, new Amount('-500')],
            [new Amount('100'), 2, new Amount('200')],
            [new Amount('50'), 50, new Amount('2500')],
        ];
    }

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
