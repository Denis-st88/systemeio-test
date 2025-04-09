<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class TaxNumber extends Constraint
{
    public string $message = 'The tax number "{{ value }}" is invalid.';
}
