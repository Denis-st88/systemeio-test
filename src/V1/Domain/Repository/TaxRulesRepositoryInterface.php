<?php

declare(strict_types=1);

namespace App\V1\Domain\Repository;

use App\V1\Domain\TaxRules;
use Doctrine\Persistence\ObjectRepository;

interface TaxRulesRepositoryInterface extends ObjectRepository
{
    public function getTaxRulesByCountryCode(string $countryCode): TaxRules;
}
