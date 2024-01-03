<?php
declare(strict_types=1);

namespace Money\Amount;

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

    public function getAmount(): string
    {
        return $this->amount;
    }
}