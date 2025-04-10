<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Calculate;

use App\V1\Api\Request\Product\CalculateProductRequestInterface;
use App\V1\Domain\Coupon;
use App\V1\Domain\Product;
use App\V1\Domain\Repository\CouponRepositoryInterface;
use App\V1\Domain\Repository\ProductRepositoryInterface;
use App\V1\Domain\Repository\TaxRulesRepositoryInterface;
use App\V1\Domain\TaxRules;
use League\Pipeline\StageInterface;

readonly class DataSetter implements StageInterface
{
    public function __construct(
        private TaxRulesRepositoryInterface $taxRulesRepository,
        private CouponRepositoryInterface   $couponRepository,
        private ProductRepositoryInterface  $productRepository
    ) {
    }

    /**
     * @param CalculateProductRequestInterface $payload
     */
    public function __invoke($payload): CalculatorDataInterface
    {
        if (!$payload instanceof CalculateProductRequestInterface) {
            throw new \LogicException(sprintf(
                'Class %s must implement %s',
                $payload::class,
                CalculateProductRequestInterface::class
            ));
        }

        return (new Data())
            ->setProduct($this->getProduct($payload->getProduct()))
            ->setTaxRules($this->getTaxRule($payload->getTaxNumber()))
            ->setCoupon($this->getCoupon($payload->getCouponCode()));
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
