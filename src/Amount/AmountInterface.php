<?php
declare(strict_types=1);

namespace Money\Amount;

interface AmountInterface
{
    public function getAmount() : string;

    public function equals(AmountInterface ...$amounts): bool;

    public function add(AmountInterface ...$amounts): AmountInterface;

    public function sub(AmountInterface ...$amounts): AmountInterface;

    public function times(int $times): AmountInterface;

    public function percent(float $percent): AmountInterface;
}