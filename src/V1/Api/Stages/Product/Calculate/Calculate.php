<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Calculate;

use App\Common\Response\ApiResponseInterface;
use App\V1\Api\Request\Product\Calculate\ApiRequest;
use App\V1\Api\Response\Product\Calculate\Response;
use App\V1\Domain\Coupon;
use App\V1\Domain\Product;
use App\V1\Domain\Repository\CouponRepositoryInterface;
use App\V1\Domain\Repository\ProductRepositoryInterface;
use App\V1\Domain\Repository\TaxRulesRepositoryInterface;
use App\V1\Domain\TaxRules;
use League\Pipeline\StageInterface;

readonly class Calculate implements StageInterface
{
    public function __construct(
        private TaxRulesRepositoryInterface $taxRulesRepository,
        private CouponRepositoryInterface   $couponRepository,
        private ProductRepositoryInterface  $productRepository
    ) {
    }

    /**
     * @param ApiRequest $payload
     */
    public function __invoke($payload): ApiResponseInterface
    {
        $product = $this->getProduct($payload->getProduct());
        $taxRule = $this->getTaxRule($payload->getTaxNumber());
        $coupon = $this->getCoupon($payload->getCouponCode());

        $priceWithTax = $product->getPrice() * (1 + $taxRule->getTaxRate() / 100);

        if ($coupon) {
            $priceWithTax = $coupon->getType() === 'fix' ?
                $priceWithTax - $coupon->getDiscount() :
                $priceWithTax * (1 - $coupon->getDiscount() / 100);
        }

        return (new Response())->setPrice(round($priceWithTax, 2));
    }

    private function getProduct(int $id): Product
    {
        return $this->productRepository->getProductById($id);
    }

    private function getTaxRule(string $taxNumber): TaxRules
    {
        return $this->taxRulesRepository->getTaxRulesByCountryCode(
            substr($taxNumber, 0, 2)
        );
    }

    private function getCoupon(string $couponCode): ?Coupon
    {
        $code = substr($couponCode, 0, 1);
        $discount = substr($couponCode, 1);

        return $this->couponRepository->findByCodeAndDiscount(
            $code,
            (float) $discount
        );
    }
}
