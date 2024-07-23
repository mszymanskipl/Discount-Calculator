<?php

namespace Mszymanskipl\DiscountCalculator\Calculators;

use Mszymanskipl\DiscountCalculator\Entities\Discount;
use Mszymanskipl\DiscountCalculator\Entities\FixedDiscount;
use Mszymanskipl\DiscountCalculator\Entities\PercentageDiscount;
use Mszymanskipl\DiscountCalculator\Entities\VolumeDiscount;

final readonly class CalculationService
{
    private FixedDiscountCalculator $fixedDiscountCalculator;
    private PercentageDiscountCalculator $percentageDiscountCalculator;
    private VolumeDiscountCalculator $volumeDiscountCalculator;

    public function __construct()
    {
        $this->fixedDiscountCalculator = new FixedDiscountCalculator();
        $this->percentageDiscountCalculator = new PercentageDiscountCalculator();
        $this->volumeDiscountCalculator = new VolumeDiscountCalculator();
    }

    /**
     * @param \Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\Discount $discount
     * @return int
     */
    public function calculateDiscount(array $products, Discount $discount): int
    {
        return match (true) {
            $discount instanceof FixedDiscount => $this->fixedDiscountCalculator->calculateDiscount(
                $products,
                $discount,
            ),
            $discount instanceof PercentageDiscount => $this->percentageDiscountCalculator->calculateDiscount(
                $products,
                $discount,
            ),
            $discount instanceof VolumeDiscount => $this->volumeDiscountCalculator->calculateDiscount(
                $products,
                $discount,
            ),
            default => throw new \InvalidArgumentException('Unsupported discount'),
        };
    }
}
