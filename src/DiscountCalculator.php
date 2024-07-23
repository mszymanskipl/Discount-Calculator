<?php

namespace Mszymanskipl\DiscountCalculator;

use Mszymanskipl\DiscountCalculator\Calculators\CalculationService;
use Mszymanskipl\DiscountCalculator\Entities\Discount;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;

final readonly class DiscountCalculator
{
    /**
     * @param \Mszymanskipl\DiscountCalculator\Calculators\CalculationService $calculationService
     * @param Discount[] $discounts
     */
    public function __construct(private CalculationService $calculationService, private array $discounts)
    {
    }

    /**
     * @param \Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface[] $products
     * @return int
     * @throws \Exception
     * @api
     */
    public function calculateTotal(array $products): int
    {
        $total = 0;

        foreach ($products as $product) {
            $total += $product->getPrice()->getAmount() * $product->getQuantity();
        }

        $total -= $this->calculateTotalDiscount($products);

        if ($total < 0) {
            throw new \Exception('Total cannot be negative');
        }

        return $total;
    }

    /**
     * @param ProductInterface[] $products
     * @return int
     */
    private function calculateTotalDiscount(array $products): int
    {
        $totalDiscount = 0;

        foreach ($this->discounts as $discount) {
            $totalDiscount += $this->calculationService->calculateDiscount($products, $discount);
        }

        return $totalDiscount;
    }
}
