<?php

namespace Tests\Traits;

use Mockery\MockInterface;
use Mszymanskipl\DiscountCalculator\Interfaces\PriceInterface;
use Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface;

trait MocksProducts
{
    /**
     * @param int $price
     * @param string $currency
     * @param int $amount
     * @param string $code
     * @return \Mszymanskipl\DiscountCalculator\Interfaces\ProductInterface&\Mockery\MockInterface
     */
    protected static function getMockProduct(
        int $price,
        string $currency,
        int $amount,
        string $code,
    ): MockInterface&ProductInterface {
        $mock = \Mockery::mock(ProductInterface::class);
        $mock->shouldReceive('getPrice')
            ->andReturn(
                \Mockery::mock(PriceInterface::class)
                    ->shouldReceive('getAmount')
                    ->andReturn($price)
                    ->getMock()
                    ->shouldReceive('getCurrency')
                    ->andReturn($currency)
                    ->getMock()
            )
            ->getMock()
            ->shouldReceive('getQuantity')
            ->andReturn($amount)
            ->getMock()
            ->shouldReceive('getCode')
            ->andReturn($code);

        return $mock;
    }
}
