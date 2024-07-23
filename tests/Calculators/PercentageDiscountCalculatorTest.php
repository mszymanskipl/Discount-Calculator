<?php

namespace Tests\Calculators;

use Mszymanskipl\DiscountCalculator\Calculators\PercentageDiscountCalculator;
use Mszymanskipl\DiscountCalculator\Entities\PercentageDiscount;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Traits\MocksProducts;

#[CoversClass(PercentageDiscountCalculator::class)]
class PercentageDiscountCalculatorTest extends TestCase
{
    use MocksProducts;

    /**
     * @param ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\PercentageDiscount $discount
     * @param int $expectedDiscount
     * @return void
     */
    #[DataProvider('calculateDiscountDataProvider')]
    public function testCalculateDiscount(
        array $products,
        PercentageDiscount $discount,
        int $expectedDiscount,
    ): void {
        $percentageDiscountCalculator = new PercentageDiscountCalculator();
        $actualDiscount = $percentageDiscountCalculator->calculateDiscount($products, $discount);
        $this->assertEquals($expectedDiscount, $actualDiscount);
    }

    /**
     * @return array<string, array{ProductInterface[], PercentageDiscount, int}>
     */
    public static function calculateDiscountDataProvider(): array
    {
        return [
            'No product restriction' => [
                [self::getMockProduct(50, 'EUR', 1, 'ABC123')],
                new PercentageDiscount(30, []),
                15,
            ],
            'Product restriction unmet' => [
                [self::getMockProduct(50, 'EUR', 1, 'ABC123')],
                new PercentageDiscount(30, ['DEF123']),
                0,
            ],
            'Product restriction met' => [
                [self::getMockProduct(50, 'EUR', 1, 'ABC123')],
                new PercentageDiscount(30, ['ABC123']),
                15,
            ],
        ];
    }
}
