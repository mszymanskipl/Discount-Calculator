<?php

namespace Tests\Calculators;

use Mszymanskipl\DiscountCalculator\Calculators\VolumeDiscountCalculator;
use Mszymanskipl\DiscountCalculator\Entities\VolumeDiscount;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Traits\MocksProducts;

#[CoversClass(VolumeDiscountCalculator::class)]
class VolumeDiscountCalculatorTest extends TestCase
{
    use MocksProducts;

    /**
     * @param ProductInterface[] $products
     * @param \Mszymanskipl\DiscountCalculator\Entities\VolumeDiscount $discount
     * @param int $expectedDiscount
     * @return void
     */
    #[DataProvider('calculateDiscountDataProvider')]
    public function testCalculateDiscount(
        array $products,
        VolumeDiscount $discount,
        int $expectedDiscount,
    ): void {
        $volumeDiscountCalculator = new VolumeDiscountCalculator();
        $actualDiscount = $volumeDiscountCalculator->calculateDiscount($products, $discount);
        $this->assertEquals($expectedDiscount, $actualDiscount);
    }

    /**
     * @return array<string, array{ProductInterface[], VolumeDiscount, int}>
     */
    public static function calculateDiscountDataProvider(): array
    {
        return [
            "Volume unmet - 1 product" => [
                [self::getMockProduct(100, 'EUR', 1, 'ABC123')],
                new VolumeDiscount(50, 'EUR', 5, []),
                0,
            ],
            "Volume unmet - multiple products" => [
                [
                    self::getMockProduct(100, 'EUR', 1, 'ABC123'),
                    self::getMockProduct(100, 'EUR', 3, 'DEF123'),
                ],
                new VolumeDiscount(50, 'EUR', 5, []),
                0,
            ],
            "Volume unmet - multiple products, code restriction" => [
                [
                    self::getMockProduct(100, 'EUR', 3, 'ABC123'),
                    self::getMockProduct(100, 'EUR', 1, 'DEF123'),
                    self::getMockProduct(100, 'EUR', 1, 'GHI123'),
                ],
                new VolumeDiscount(50, 'EUR', 5, ['ABC123', 'DEF123']),
                0,
            ],
            "Volume met - 1 product" => [
                [self::getMockProduct(100, 'EUR', 5, 'ABC123')],
                new VolumeDiscount(50, 'EUR', 5, []),
                50,
            ],
            "Volume met - multiple products" => [
                [
                    self::getMockProduct(100, 'EUR', 3, 'ABC123'),
                    self::getMockProduct(100, 'EUR', 1, 'DEF123'),
                    self::getMockProduct(100, 'EUR', 1, 'GHI123'),
                ],
                new VolumeDiscount(50, 'EUR', 5, []),
                50,
            ],
            "Volume met - multiple products, code restriction" => [
                [
                    self::getMockProduct(100, 'EUR', 3, 'ABC123'),
                    self::getMockProduct(100, 'EUR', 1, 'DEF123'),
                    self::getMockProduct(100, 'EUR', 1, 'GHI123'),
                ],
                new VolumeDiscount(50, 'EUR', 5, ['ABC123', 'DEF123', 'GHI123']),
                50,
            ],
        ];
    }
}
