<?php
declare(strict_types=1);

namespace Money;

use Money\Amount\Amount;
use Money\Amount\AmountInterface;
use Money\Calculator\CalculatorInterface;
use Money\Calculator\Provider\CalculatorProvider;
use Money\Currency\CurrencyInterface;

final readonly class Money implements \JsonSerializable
{
    public function __construct(private AmountInterface $amount, private CurrencyInterface $currency)
    {}

    public function __clone()
    {
        $this->amount = clone $this->amount;
        $this->currency = clone $this->currency;
    }

    public static function getCalculator(): CalculatorInterface
    {
        return CalculatorProvider::get();
    }

    public function getAmount(): string
    {
        return $this->amount->getAmount();
    }

    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    public function equals(Money ...$moneys): bool
    {
        if (!$this->identicalCurrencies(...$moneys)) {
            return false;
        }

        foreach ($moneys as $money) {
            if ($money->getAmount() !== $this->getAmount()) {
                return false;
            }
        }

        return true;
    }

    public function identicalCurrencies(Money ...$moneys): bool
    {
        foreach ($moneys as $money) {
            if ($money->currency->getCode() !== $this->currency->getCode()) {
                return false;
            }
        }

        return true;
    }

    public function add(Money ...$moneys): Money
    {
        if (!$this->identicalCurrencies(...$moneys)) {
            throw new \InvalidArgumentException('Currencies must be identical');
        }

        $amount = $this->getAmount();

        foreach ($moneys as $money) {
            $amount = self::getCalculator()->add($amount, $money->getAmount());
        }

        return new self(new Amount($amount), clone $this->currency);
    }

    public function sub(Money ...$moneys): Money
    {
        if (!$this->identicalCurrencies(...$moneys)) {
            throw new \InvalidArgumentException('Currencies must be identical');
        }

        $amount = $this->getAmount();

        foreach ($moneys as $money) {
            $amount = self::getCalculator()->sub($amount, $money->getAmount());
        }

        return new self(new Amount($amount), clone $this->currency);
    }

    public function percent(float $percent): Money
    {
        $amount = self::getCalculator()->percent($this->getAmount(), (string)$percent, 0);

        return new self(new Amount($amount), clone $this->currency);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'amount' => $this->amount->getAmount(),
            'currency' => $this->currency->getCode()
        ];
    }
}