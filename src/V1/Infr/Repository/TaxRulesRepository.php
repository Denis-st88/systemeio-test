<?php

declare(strict_types=1);

namespace App\V1\Infr\Repository;

use App\V1\Domain\Repository\TaxRulesRepositoryInterface;
use App\V1\Domain\TaxRules;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class TaxRulesRepository extends ServiceEntityRepository implements TaxRulesRepositoryInterface
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, TaxRules::class);
    }

    public function getTaxRulesByCountryCode(string $countryCode): TaxRules
    {
        try {
            return $this->createQueryBuilder('tax')
                ->where('tax.countryCode = :countryCode')
                ->setParameter('countryCode', $countryCode)
                ->getQuery()
                ->getSingleResult();
        } catch (ORMException $e) {
            throw new EntityNotFoundException('TaxRules entity not found.');
        }
    }
}
