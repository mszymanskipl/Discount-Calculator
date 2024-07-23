<?php

namespace Mszymanskipl\DiscountCalculator\Calculators;

use Mszymanskipl\DiscountCalculator\Entities\PercentageDiscount;

final readonly class PercentageDiscountCalculator
{
    /**
     * @param \Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\PercentageDiscount $discount
     * @return int
     */
    public function calculateDiscount(array $products, PercentageDiscount $discount): int
    {
        $totalDiscount = 0;
        foreach ($products as $product) {
            if (empty($discount->getProductCodes()) || in_array($product->getCode(), $discount->getProductCodes())) {
                $decimalPercentage = $discount->getPercentage() / 100;
                $totalDiscount += $decimalPercentage * $product->getPrice()->getAmount() * $product->getQuantity();
            }
        }

        return (int) floor($totalDiscount);
    }
}
