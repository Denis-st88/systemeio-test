<?php

declare(strict_types=1);

namespace App\V1\Domain;

use App\V1\Infr\Repository\TaxRulesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tax_rules')]
#[ORM\Entity(repositoryClass: TaxRulesRepository::class)]
class TaxRules
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(
        name: 'country_code',
        type: 'string',
        length: 2,
        unique: true,
        nullable: false
    )]
    private string $countryCode;

    #[ORM\Column(
        name: 'country_name',
        type: 'string',
        length: 100,
        nullable: false
    )]
    private string $countryName;

    #[ORM\Column(
        name: 'tax_rate',
        type: 'float',
        nullable: false
    )]
    private float $taxRate;

    #[ORM\Column(
        name: 'tax_number_pattern',
        type: 'string',
        length: 255,
        nullable: false
    )]
    private string $taxNumberPattern;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function setTaxRate(float $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getTaxNumberPattern(): string
    {
        return $this->taxNumberPattern;
    }

    public function setTaxNumberPattern(string $taxNumberPattern): self
    {
        $this->taxNumberPattern = $taxNumberPattern;

        return $this;
    }
}
