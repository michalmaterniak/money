<?php
declare(strict_types=1);

namespace Money\Amount;

use Money\Calculator\CalculatorInterface;
use Money\Calculator\Provider\CalculatorProvider;

readonly class Amount implements AmountInterface
{
    protected string $amount;

    public function __construct(int|float|string $amount)
    {
        $amount = (string)$amount;

        if (!preg_match("/^-?[1-9]\d*$|^0$/m", $amount)) {
            throw new \InvalidArgumentException('Amount must be a number.');
        }

        $this->amount = $amount;
    }

    protected static function getCalculator(): CalculatorInterface
    {
        return CalculatorProvider::get();
    }

    public function getAmount(): string
    {
        return $this->amount;
    }


    public function add(AmountInterface ...$amounts): AmountInterface
    {
        $current = $this->getAmount();

        foreach ($amounts as $amount) {
            $current = static::getCalculator()->add($current, $amount->getAmount());
        }

        return new static($current);
    }

    public function sub(AmountInterface ...$amounts): AmountInterface
    {
        $current = $this->getAmount();

        foreach ($amounts as $amount) {
            $current = static::getCalculator()->sub($current, $amount->getAmount());
        }

        return new static($current);
    }

    public function times(int $times): AmountInterface
    {
        return new static(static::getCalculator()->times($this->getAmount(), $times));
    }

    public function percent(float $percent): AmountInterface
    {
        $amount = static::getCalculator()->percent($this->getAmount(), (string)$percent);

        return new static($amount);
    }

    public function equals(AmountInterface ...$amounts): bool
    {
        foreach ($amounts as $amount) {
            if ($amount->getAmount() !== $this->getAmount()) {
                return false;
            }
        }

        return true;
    }
}