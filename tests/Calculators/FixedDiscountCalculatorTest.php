<?php

namespace Tests\Calculators;

use Mszymanskipl\DiscountCalculator\Calculators\FixedDiscountCalculator;
use Mszymanskipl\DiscountCalculator\Entities\FixedDiscount;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Traits\MocksProducts;

#[CoversClass(FixedDiscountCalculator::class)]
class FixedDiscountCalculatorTest extends TestCase
{
    use MocksProducts;

    /**
     * @param \Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\FixedDiscount $discount
     * @param int $expectedDiscount
     * @return void
     */
    #[DataProvider('calculateDiscountDataProvider')]
    public function testCalculateDiscount(
        array $products,
        FixedDiscount $discount,
        int $expectedDiscount,
    ): void {
        $fixedDiscountCalculator = new FixedDiscountCalculator();
        $actualDiscount = $fixedDiscountCalculator->calculateDiscount($products, $discount);
        $this->assertEquals($expectedDiscount, $actualDiscount);
    }


    /**
     * @return array<string, array{ProductInterface[], FixedDiscount, int}>
     */
    public static function calculateDiscountDataProvider(): array
    {
        return [
            'No product restriction' => [
                [self::getMockProduct(100, 'EUR', 1, 'ABC123')],
                new FixedDiscount(30, 'EUR', []),
                30,
            ],
            'Product restriction unmet' => [
                [self::getMockProduct(100, 'EUR', 1, 'ABC123')],
                new FixedDiscount(30, 'EUR', ['DEF123']),
                0,
            ],
            'Product restriction met' => [
                [self::getMockProduct(100, 'EUR', 1, 'ABC123')],
                new FixedDiscount(30, 'EUR', ['ABC123']),
                30,
            ],
        ];
    }
}
