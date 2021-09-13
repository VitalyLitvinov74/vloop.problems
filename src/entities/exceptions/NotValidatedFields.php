<?php


namespace vloop\problems\entities\exceptions;

use vloop\problems\entities\abstractions\contracts\VloopException;

class NotValidatedFields extends \Exception implements VloopException
{
    private $errors;

    public function __construct(array $errors, int $code) {
        $this->errors = $errors;
        parent::__construct('', $code);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}