<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

use App\V1\Api\Enum\PaymentType;
use InvalidArgumentException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class PaymentProcessorFactory
{
    public function __construct(
        private PaypalPaymentProcessor $paypal,
        private StripePaymentProcessor $stripe,
    ) {}

    public function create(string $type): PaymentProcessorInterface
    {
        return match ($type) {
            PaymentType::Paypal->value => new PaypalPaymentAdapter($this->paypal),
            PaymentType::Stripe->value => new StripePaymentAdapter($this->stripe),
            default => throw new InvalidArgumentException(sprintf(
                'Unsupported payment type: %s',
                $type
            )),
        };
    }
}

