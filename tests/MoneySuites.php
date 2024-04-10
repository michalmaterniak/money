<?php
declare(strict_types=1);

namespace Test\Money;

use Money\Amount\Amount;
use Money\Currency\Currency;
use Money\Money;

trait MoneySuites
{
    public static function validMathMoney(): array
    {
        return [
            [
                [
                    new Money(new Amount(0), new Currency('USD')),
                    new Money(new Amount(100), new Currency('USD')),
                ],
                ['add' => "100", 'sub' => '-100', 'mul' => ['0.5' => ["0", "50"], "0.126" => ["0", "13"]]],
            ],
            [
                [
                    new Money(new Amount(123), new Currency('USD')),
                    new Money(new Amount(321), new Currency('USD')),
                ],
                ['add' => "444", 'sub' => '-198', 'mul' => ['0.5' => ["62", "161"], "0.126" => ["15", "40"]]],
            ],
            [
                [
                    new Money(new Amount('-100'), new Currency('USD')),
                    new Money(new Amount('100'), new Currency('USD')),
                    new Money(new Amount('50'), new Currency('USD')),
                ],
                ['add' => "50", 'sub' => '-250', 'mul' => ['0.5' => ["-50", "50", "25"], "0.126" => ["-13", "13", "6"]]],
            ],
            [
                [
                    new Money(new Amount('-9999'), new Currency('USD')),
                    new Money(new Amount('-999'), new Currency('USD')),
                ],
                ['add' => "-10998", 'sub' => '-9000', 'mul' => ['0.5' => ["-5000", "-500"], "0.126" => ["-1260", "-126"]]],
            ],
            [
                [
                    new Money(new Amount('123311123'), new Currency('USD')),
                    new Money(new Amount('3213212312'), new Currency('USD')),
                ],
                [
                    'add' => "3336523435",
                    'sub' => '-3089901189',
                    'mul' => [
                        '0.5' => ["61655562", "1606606156"],
                        "0.126" => ["15537201", "404864751"]
                    ]
                ],
            ]
        ];
    }

    public static function invalidMathMoneyDiffrentCurrencies(): array
    {
        return [
            [
                new Money(new Amount('123'), new Currency('USD')),
                new Money(new Amount(321), new Currency('EUR')),
            ],
            [
                new Money(new Amount('123'), new Currency('PLN')),
                new Money(new Amount(321), new Currency('EUR')),
            ]
        ];
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
            ]
        ];
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
            ]
        ];
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
            ]
        ];
    }

    public static function currencyCodes(): array
    {
        return [
            [new Money(new Amount(-12), new Currency('USD')), 'USD', true],
            [new Money(new Amount(-12), new Currency('USD')), 'EUR', false]
        ];
    }
}