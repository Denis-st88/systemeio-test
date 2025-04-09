<?php

declare(strict_types=1);

namespace App\Common\Exception;

class ValidationException extends \Exception
{
    /**
     * @var array<string, string>
     */
    private array $errors;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
