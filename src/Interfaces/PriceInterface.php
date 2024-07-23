<?php

namespace Mszymanskipl\DiscountCalculator\Interfaces;

interface PriceInterface
{
    public function getAmount(): int;
    public function getCurrency(): string;
}
