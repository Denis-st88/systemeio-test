<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Validator\Coupon;

use App\V1\Domain\Repository\CouponRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CouponValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CouponRepositoryInterface $couponRepository
    ) {
    }

    /**
     * @param string $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if ($value === null || $value === '' || !$constraint instanceof Coupon) {
            return;
        }

        $coupon = $this->couponRepository->findByCodeAndDiscount(
            substr($value, 0, 1),
            (float) substr($value, 1)
        );

        if ($coupon === null) {
            $this->context
                ->buildViolation(sprintf('The coupon "%s" does not exist', $value))
                ->addViolation();
        }
    }
}
