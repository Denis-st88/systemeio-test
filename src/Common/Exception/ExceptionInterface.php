<?php

declare(strict_types=1);

namespace App\Common\Exception;

interface ExceptionInterface
{
    /**
     * @return array<string, string>
     */
    public function getErrors(): array;

    /**
     * @param array<string, string> $errors
     */
    public function setErrors(array $errors): ExceptionInterface;
}
