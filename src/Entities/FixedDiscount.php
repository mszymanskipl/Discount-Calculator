<?php

namespace Mszymanskipl\DiscountCalculator\Entities;

final readonly class FixedDiscount extends Discount
{
    /**
     * @param int $amount
     * @param string $currency
     * @param non-empty-string[] $productCodes
     */
    public function __construct(private int $amount, private string $currency, array $productCodes)
    {
        parent::__construct($productCodes);
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
