<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Validator\TaxNumber;

use App\V1\Domain\Repository\TaxRulesRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public function __construct(
        private readonly TaxRulesRepositoryInterface $taxRulesRepository
    ) {
    }

    /**
     * @param string $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$value || !preg_match('/^[A-Z]{2}/', $value)) {
            $this->context
                ->buildViolation('Invalid tax number format.')
                ->addViolation();
            return;
        }

        try {
            $taxRule = $this->taxRulesRepository->getTaxRulesByCountryCode(
                substr($value, 0, 2)
            );
        } catch (EntityNotFoundException) {
            $taxRule = null;
        }

        if (!$taxRule || !preg_match('/' . $taxRule->getTaxNumberPattern() . '/', $value)) {
            $this->context
                ->buildViolation('Invalid tax number.')
                ->addViolation();
        }
    }
}
