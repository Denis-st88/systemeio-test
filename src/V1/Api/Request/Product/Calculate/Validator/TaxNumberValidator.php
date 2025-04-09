<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Product\Calculate\Validator;

use App\V1\Domain\Repository\TaxRulesRepositoryInterface;
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
     * @param TaxNumber $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (is_null($value) || $value === '') {
            return;
        }

        $taxNumberPattern = $this->getTaxNumberPattern($value);

        if (is_null($taxNumberPattern) || !preg_match("/{$taxNumberPattern}/", $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function getTaxNumberPattern(string $value): ?string
    {
        $countryCode = null;

        if (preg_match('/^([A-Z]{2})/', $value, $matches)) {
            $countryCode = $matches[1];
        }

        $taxRules = $countryCode ?
            $this->taxRulesRepository->getTaxRulesByCountryCode($countryCode) : null;

        if (is_null($taxRules)) {
            return null;
        }

        return $taxRules->getTaxNumberPattern();
    }
}
