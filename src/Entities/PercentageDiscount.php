<?php

namespace Mszymanskipl\DiscountCalculator\Entities;

final readonly class PercentageDiscount extends Discount
{
    public function __construct(private int $percentage, array $productCodes)
    {
        parent::__construct($productCodes);
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }
}
