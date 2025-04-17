<?php

declare(strict_types=1);

namespace App\V1\Api\Calculator;

use App\V1\Api\Enum\CouponType;

class Calculator implements CalculatorInterface
{
    public function calculate(
        int $price,
        float $taxRate,
        ?float $discount = null,
        ?string $discountType = null,
    ): int
    {
        $priceWithTax = (int) round($price * (1 + $taxRate / 100));

        if ($discount !== null && $discountType !== null) {
            $priceWithTax = $this->applyDiscount($priceWithTax, $discount, $discountType);
        }

        return $priceWithTax;
    }

    private function applyDiscount(
        int $priceWithTax,
        float $discount,
        string $discountType,
    ): int
    {
        if ($discountType === CouponType::Fix->value) {
            $discount = (int) round($discount * 100);

            if ($discount < $priceWithTax) {
                return $priceWithTax - $discount;
            }
        }

        if ($discountType === CouponType::Percent->value && $discount < 100) {
            return (int) round($priceWithTax * (1 - $discount / 100));
        }

        return $priceWithTax;
    }
}
