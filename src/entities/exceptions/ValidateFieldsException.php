<?php


namespace vloop\problems\entities\exceptions;


use Throwable;
use vloop\problems\entities\abstractions\AbstractException;

class ValidateFieldsException extends AbstractException
{
    private $errors;

    public function __construct(array $errors, int $code) {
        $this->errors = $errors;
        parent::__construct('', $code);
    }

    function errors(): array
    {
        return $this->errors;
    }
}