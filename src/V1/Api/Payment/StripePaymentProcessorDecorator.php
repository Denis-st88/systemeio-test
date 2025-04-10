<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripePaymentProcessorDecorator implements PaymentProcessorInterface
{
    public function __construct(private StripePaymentProcessor $paymentProcessor)
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(float $price): void
    {
        try {
            $result = $this->paymentProcessor->processPayment($price);
        } catch (\Exception $e) {
            throw new PaymentProcessException(sprintf(
                'Failed to make a payment. Msg: %s',
                $e->getMessage()
            ));
        }

        if (!$result) {
            throw new PaymentProcessException('Price must be less then 100');
        }
    }
}
