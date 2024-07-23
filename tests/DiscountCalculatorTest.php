<?php

namespace Tests;

use Mszymanskipl\DiscountCalculator\Calculators\CalculationService;
use Mszymanskipl\DiscountCalculator\DiscountCalculator;
use Mszymanskipl\DiscountCalculator\Entities\Discount;
use Mszymanskipl\DiscountCalculator\Entities\FixedDiscount;
use Mszymanskipl\DiscountCalculator\Entities\PercentageDiscount;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Traits\MocksProducts;

#[CoversClass(DiscountCalculator::class)]
class DiscountCalculatorTest extends TestCase
{
    use MocksProducts;

    /**
     * @param ProductInterface[] $products
     * @param Discount[] $discounts
     * @param int $expectedTotal
     * @return void
     * @throws \Exception
     */
    #[DataProvider('calculateTotalDataProvider')]
    public function testCalculateTotal(array $products, array $discounts, int $expectedTotal): void
    {
        $calculationService = new CalculationService();
        $discountCalculator = new DiscountCalculator($calculationService, $discounts);
        $result = $discountCalculator->calculateTotal($products);
        $this->assertEquals($expectedTotal, $result);
    }

    /**
     * @return array<string, array{ProductInterface[], Discount[], int}>
     */
    public static function calculateTotalDataProvider(): array
    {
        return [
            "No discount - straight total" => [
                [
                    self::getMockProduct(100, 'EUR', 1, 'ABC123'),
                    self::getMockProduct(23, 'EUR', 2, 'DEF123'),
                ],
                [],
                146,
            ],
            "Fixed discount of 100 EUR" => [
                [
                    self::getMockProduct(100, 'EUR', 1, 'ABC123'),
                    self::getMockProduct(23, 'EUR', 2, 'DEF123'),
                ],
                [new FixedDiscount(100, 'EUR', [])],
                46,
            ],
            "Fixed discount of 50 EUR, 50% off DEF123" => [
                [
                    self::getMockProduct(100, 'EUR', 1, 'ABC123'),
                    self::getMockProduct(250, 'EUR', 2, 'DEF123'),
                ],
                [
                    new FixedDiscount(50, 'EUR', []),
                    new PercentageDiscount(50, ['DEF123'])
                ],
                300,
            ],
        ];
    }
}
