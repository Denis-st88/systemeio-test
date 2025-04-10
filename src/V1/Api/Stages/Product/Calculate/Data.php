<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Calculate;

use App\V1\Domain\Coupon;
use App\V1\Domain\Product;
use App\V1\Domain\TaxRules;

class Data implements CalculatorDataInterface
{
    private Product $product;
    private TaxRules $taxRules;
    private ?Coupon $coupon = null;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getTaxRules(): TaxRules
    {
        return $this->taxRules;
    }

    public function setTaxRules(TaxRules $taxRules): self
    {
        $this->taxRules = $taxRules;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }
}
