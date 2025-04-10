<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

readonly class PaypalPaymentProcessorDecorator implements PaymentProcessorInterface
{

    public function __construct(private PaypalPaymentProcessor $paypalPaymentProcessor)
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(float $price): void
    {
        try {
            $this->paypalPaymentProcessor->pay((int) $price);
        } catch (\Exception $e) {
            throw new PaymentProcessException(sprintf(
                'Failed to make a payment. Msg: %s',
                $e->getMessage()
            ));
        }
    }
}
