<?php


namespace vloop\problems\entities\exceptions;


use Throwable;
use vloop\problems\entities\abstractions\contracts\VloopException;

class NotSavedRecord extends \Exception implements VloopException
{
    private $errors;

    public function __construct(array $modelErrors, $code = 0) {
        $this->errors = $modelErrors;
        parent::__construct('', $code);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}