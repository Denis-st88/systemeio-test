<?php

declare(strict_types=1);

namespace App\Common\Stages;

use App\Common\Exception\ValidationException;
use App\Common\Request\ApiRequestInterface;
use League\Pipeline\StageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ApiRequestValidator implements StageInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @param ApiRequestInterface $apiRequest
     *
     * @throws ValidationException
     */
    public function __invoke($apiRequest): ApiRequestInterface
    {
        $violations = $this->validator->validate($apiRequest);

        if (\count($violations) > 0) {
            $errors = [];

            foreach ($violations as $violation) {
                $errors[] = [
                    'field' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            throw (new ValidationException())->setErrors($errors);
        }

        return $apiRequest;
    }
}
