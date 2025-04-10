<?php

namespace App\V1\Api\Enum;

enum CouponType: string
{
    case Fix = 'fix';
    case Percent = 'percent';
}
