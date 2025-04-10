<?php

declare(strict_types=1);

namespace App\V1\Api\Calculator;

use App\V1\Api\Stages\Product\Calculate\CalculatorDataInterface;

class Calculator implements CalculatorInterface
{
    public function calculate(CalculatorDataInterface $data): float
    {
        $productPrice = $data->getProduct()->getPrice();
        $taxRate = $data->getTaxRules()->getTaxRate();
        $coupon = $data->getCoupon();

        $priceWithTax = $productPrice * (1 + $taxRate / 100);

        if ($coupon) {
            $priceWithTax = $coupon->getType() === 'fix' ?
                $priceWithTax - $coupon->getDiscount() :
                $priceWithTax * (1 - $coupon->getDiscount() / 100);
        }

        return $priceWithTax;
    }
}
