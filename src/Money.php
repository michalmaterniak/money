<?php
declare(strict_types=1);

namespace Money;

use Money\Amount\AmountInterface;
use Money\Calculator\CalculatorInterface;
use Money\Calculator\Provider\CalculatorProvider;
use Money\Currency\CurrencyInterface;

readonly class Money implements \JsonSerializable, MoneyInterface
{
    public function __construct(protected AmountInterface $amount, protected CurrencyInterface $currency)
    {}

    public function __clone()
    {
        $this->amount = clone $this->amount;
        $this->currency = clone $this->currency;
    }

    protected static function getCalculator(): CalculatorInterface
    {
        return CalculatorProvider::get();
    }

    public function getAmount(): string
    {
        return $this->amount->getAmount();
    }

    public function getCurrencyCode(): string
    {
        return $this->currency->getCode();
    }

    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    public function equals(MoneyInterface ...$moneys): bool
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

    public function identicalCurrencies(MoneyInterface ...$moneys): bool
    {
        foreach ($moneys as $money) {
            if ($money->getCurrency()->getCode() !== $this->currency->getCode()) {
                return false;
            }
        }

        return true;
    }

    public function add(MoneyInterface ...$moneys): MoneyInterface
    {
        if (!$this->identicalCurrencies(...$moneys)) {
            throw new \InvalidArgumentException('Currencies must be identical');
        }

        $amounts = [];

        foreach ($moneys as $money) {
            $amounts[] = $money->amount;
        }

        return new static($this->amount->add(...$amounts), clone $this->currency);
    }

    public function sub(MoneyInterface ...$moneys): MoneyInterface
    {
        if (!$this->identicalCurrencies(...$moneys)) {
            throw new \InvalidArgumentException('Currencies must be identical');
        }

        $amounts = [];

        foreach ($moneys as $money) {
            $amounts[] = $money->amount;
        }

        return new static($this->amount->sub(...$amounts), clone $this->currency);
    }

    public function times(int $times): MoneyInterface
    {
        return new static($this->amount->times($times), clone $this->currency);
    }

    public function percent(float $percent): MoneyInterface
    {
        return new static($this->amount->percent($percent), clone $this->currency);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'amount' => $this->amount->getAmount(),
            'currency' => $this->currency->getCode()
        ];
    }
}