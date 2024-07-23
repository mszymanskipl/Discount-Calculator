<?php

namespace Mszymanskipl\DiscountCalculator\Entities;

final readonly class VolumeDiscount extends Discount
{
    public function __construct(
        private int $amount,
        private string $currency,
        private int $volume,
        array $productCodes,
    ) {
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

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }
}
