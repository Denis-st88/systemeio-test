<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Product;

interface CalculateProductRequestInterface
{
    public function getProduct(): int;

    public function setProduct(int $product): CalculateProductRequestInterface;

    public function getTaxNumber(): string;

    public function setTaxNumber(string $taxNumber): CalculateProductRequestInterface;

    public function getCouponCode(): ?string;

    public function setCouponCode(?string $couponCode): CalculateProductRequestInterface;
}
