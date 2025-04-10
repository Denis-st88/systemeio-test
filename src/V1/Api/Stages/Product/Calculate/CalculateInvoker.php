<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Calculate;

use App\Common\Response\ApiResponseInterface;
use App\V1\Api\Calculator\CalculatorInterface;
use App\V1\Api\Response\Product\Calculate\Response;
use League\Pipeline\StageInterface;

readonly class CalculateInvoker implements StageInterface
{
    public function __construct(private CalculatorInterface $calculator)
    {
    }

    /**
     * @param CalculatorDataInterface $payload
     */
    public function __invoke($payload): ApiResponseInterface
    {
        $price = $this->calculator->calculate(
            $payload->getProduct()->getPrice(),
            $payload->getTaxRules()->getTaxRate(),
            $payload->getCoupon()?->getDiscount(),
            $payload->getCoupon()?->getType()
        );

        return (new Response())->setPrice($price);
    }
}
