<?php

namespace Mszymanskipl\DiscountCalculator\Calculators;

use Mszymanskipl\DiscountCalculator\Entities\FixedDiscount;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;

final readonly class FixedDiscountCalculator
{
    /**
     * @param ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\FixedDiscount $discount
     * @return int
     */
    public function calculateDiscount(array $products, FixedDiscount $discount): int
    {
        if (empty($discount->getProductCodes())) {
            return $discount->getAmount();
        }

        foreach ($products as $product) {
            if (in_array($product->getCode(), $discount->getProductCodes())) {
                return $discount->getAmount();
            }
        }

        return 0;
    }
}
