<?php

declare(strict_types=1);

namespace nif\exceptions;

use Exception;

class ValidationException extends Exception
{
    protected array $errors = [];

    public function setErrors(array $errors): ValidationException
    {
        $this->errors = $errors;
        return $this;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }
}
