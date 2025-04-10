<?php

namespace App\Common\Exception;

class CommonException extends \Exception implements ExceptionInterface
{
    /**
     * @var array<string, string>
     */
    private array $errors = [];

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array<string, string> $errors
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
