<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Calculate;

use App\V1\Domain\Coupon;
use App\V1\Domain\Product;
use App\V1\Domain\TaxRules;

interface CalculatorDataInterface
{
    public function getProduct(): Product;

    public function setProduct(Product $product): CalculatorDataInterface;

    public function getTaxRules(): TaxRules;

    public function setTaxRules(TaxRules $taxRules): CalculatorDataInterface;

    public function getCoupon(): ?Coupon;

    public function setCoupon(?Coupon $coupon): CalculatorDataInterface;
}
