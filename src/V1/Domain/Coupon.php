<?php

declare(strict_types=1);

namespace App\V1\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'coupon')]
class Coupon
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(
        name: 'code',
        type: 'string',
        length: 1,
        nullable: false
    )]
    private string $code;

    #[ORM\Column(
        name: 'type',
        type: 'string',
        length: 100,
        nullable: false
    )]
    private string $type;

    #[ORM\Column(
        name: 'discount',
        type: 'float',
        nullable: false
    )]
    private float $discount;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
