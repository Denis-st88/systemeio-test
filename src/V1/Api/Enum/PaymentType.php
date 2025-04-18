<?php

declare(strict_types=1);

namespace App\V1\Api\Enum;

enum PaymentType: string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
