<?php

namespace Mszymanskipl\DiscountCalculator\Entities;

readonly abstract class Discount
{
    /**
     * @param non-empty-string[] $productCodes Product codes for which the discount applies. If empty, then it applies
     * to all products.
     */
    public function __construct(protected array $productCodes = [])
    {
    }

    /**
     * @return non-empty-string[]
     */
    public function getProductCodes(): array
    {
        return $this->productCodes;
    }
}
