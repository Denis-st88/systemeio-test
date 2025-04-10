<?php

declare(strict_types=1);

namespace App\V1\Api\Calculator;

use App\V1\Api\Enum\CouponType;

class Calculator implements CalculatorInterface
{
    public function calculate(
        float $price,
        float $taxRate,
        ?float $discount = null,
        ?string $discountType = null,
    ): float
    {
        $priceWithTax = $price * (1 + $taxRate / 100);

        if ($discount && $discountType) {
            $priceWithTax = $this->calculateDiscount(
                $priceWithTax,
                $discount,
                $discountType
            );
        }

        return round($priceWithTax, 2);
    }

    private function calculateDiscount(
        float $priceWithTax,
        float $discount,
        string $discountType,
    ): float
    {
        if ($discountType === CouponType::Fix->value && $discount < $priceWithTax) {
            return $priceWithTax - $discount;
        }

        if ($discountType === CouponType::Percent->value && $discount < 100) {
            return $priceWithTax * (1 - $discount / 100);
        }

        return $priceWithTax;
    }
}
