<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\V1\Api\Calculator\Calculator;
use Codeception\Test\Unit;

class PriceCalculatorTest extends Unit
{
    private Calculator $calculator;

    protected function _before(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * @dataProvider data
     */
    public function testCalculatePrice(
        float $expected,
        int $price,
        float $taxRate,
        ?float $discount = null,
        ?string $discountType = null
    ): void
    {
        $final = $this->calculator->calculate($price, $taxRate, $discount, $discountType);

        $this->assertEquals($expected, $final);
    }

    public static function data(): array
    {
        return [
            '100 EUR: tax-24%, coupon-(percent)-10%' => [111.6, 100, 24, 10, 'percent'],
            '20 EUR: tax-22%, coupon-(fix)-10' => [14.4, 20, 22, 10, 'fix'],
            '10 EUR: tax-19%, coupon-(fix, bigger then price)-20' => [11.9, 10, 19, 20, 'fix'],
            '5 EUR: tax-19%, coupon-(percent, bigger then price)-100%' => [5.95, 5, 19, 100, 'percent'],
            '80 EUR: tax-20%' => [96, 80, 20],
        ];
    }
}
