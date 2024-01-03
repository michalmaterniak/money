<?php
declare(strict_types=1);

namespace Money\Amount;

interface AmountInterface
{
    public function getAmount() : string;
}