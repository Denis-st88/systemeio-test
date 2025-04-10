<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Purchase;

use App\Common\Response\ApiResponseInterface;
use App\V1\Api\Calculator\CalculatorInterface;
use App\V1\Api\Payment\PaymentProcessAbstractFactory;
use App\V1\Api\Payment\PaymentProcessException;
use App\V1\Api\Request\Product\Purchase\ApiRequest;
use App\V1\Api\Response\Product\Purchase\Response;
use App\V1\Api\Stages\Product\Calculate\CalculatorDataInterface;
use League\Pipeline\StageInterface;

readonly class MakePayment implements StageInterface
{
    public function __construct(
        private StageInterface      $calculatorDataSetter,
        private CalculatorInterface $calculator
    ) {
    }

    /**
     * @param ApiRequest $payload
     *
     * @throws PaymentProcessException
     */
    public function __invoke($payload): ApiResponseInterface
    {
        /** @var CalculatorDataInterface $data */
        $data = ($this->calculatorDataSetter)($payload);

        $price = $this->calculator->calculate(
            $data->getProduct()->getPrice(),
            $data->getTaxRules()->getTaxRate(),
            $data->getCoupon()?->getDiscount(),
            $data->getCoupon()?->getType()
        );

        $paymentProcess = (new PaymentProcessAbstractFactory(
            $payload->getPaymentProcessor()
        ))->create();

        try {
            $paymentProcess->pay($price);
        } catch (PaymentProcessException $e) {
            throw new PaymentProcessException($e->getMessage());
        }

        return (new Response())->setCode('SUCCESS');
    }
}
