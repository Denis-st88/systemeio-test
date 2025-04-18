<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Product;

use App\Common\Request\ApiRequestInterface;
use App\V1\Api\Request\Validator\TaxNumber\TaxNumber as TaxNumberAssert;
use App\V1\Api\Request\Validator\Coupon\Coupon as CouponAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ApiRequest implements ApiRequestInterface, CalculateProductRequestInterface
{
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    private int $product;

    #[TaxNumberAssert]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $taxNumber;

    #[CouponAssert]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $couponCode = null;

    public function getProduct(): int
    {
        return $this->product;
    }

    public function setProduct(int $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(?string $couponCode): self
    {
        $this->couponCode = $couponCode;

        return $this;
    }
}
