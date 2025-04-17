<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(private StripePaymentProcessor $stripe)
    {
    }

    /**
     * @throws PaymentProcessException
     */
    public function pay(int $price): void
    {
        // Stripe принимает float, надо перевести из копеек
        $priceInCurrency = $price / 100;

        if (!$this->stripe->processPayment($priceInCurrency)) {
            throw new PaymentProcessException('Stripe payment failed');
        }
    }
}
