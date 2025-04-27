<?php

declare(strict_types = 1);

namespace Money\Currency;

use Money\Currency\Resources\CurrencyResources;
use Money\Currency\Resources\CurrencyResourcesInterface;

class CurrencyInfoFactory
{
    private static array|null $currencies = null;

    private static array $defaultCurrenciesResources = [
        CurrencyResources::class,
    ];

    public static function create(string $code): ?CurrencyInfo
    {
        static::setCurrencies();

        if (false === isset(static::$currencies[$code])) {
            return null;
        }

        $currencyData = self::$currencies[$code];

        return new CurrencyInfo(
            code: $code,
            name: $currencyData['name'],
            majorUnit: $currencyData['majorUnit'],
        );
    }

    public static function addCurrency(string $code, string $name, int $majorUnit): void
    {
        static::setCurrencies();

        self::$currencies[$code] = [
            'name'      => $name,
            'majorUnit' => $majorUnit,
        ];
    }

    private static function getCurrency(string $code): ?array
    {
        static::setCurrencies();

        return self::$currencies[$code] ?? null;
    }

    public static function setResource(CurrencyResourcesInterface $resources, bool $clear = false) {}

    private static function getFromResources(): array
    {
        $currencies = [];
        foreach (static::$defaultCurrenciesResources as $resources) {
            $currencies = [...$currencies, ...$resources::get()];
        }

        return $currencies;
    }

    private static function setCurrencies(): void
    {
        if (null === self::$currencies) {
            static::$currencies = static::getFromResources();
        }
    }
}
