<?php

namespace Mszymanskipl\DiscountCalculator\Calculators;

use Mszymanskipl\DiscountCalculator\Entities\VolumeDiscount;

final readonly class VolumeDiscountCalculator
{
    /**
     * @param \Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\VolumeDiscount $discount
     * @return int
     */
    public function calculateDiscount(array $products, VolumeDiscount $discount): int
    {
        $productCount = 0;
        foreach ($products as $product) {
            if (!empty($discount->getProductCodes()) && !in_array($product->getCode(), $discount->getProductCodes())) {
                continue;
            }

            $productCount += $product->getQuantity();
            if ($productCount >= $discount->getVolume()) {
                return $discount->getAmount();
            }
        }

        return 0;
    }
}
