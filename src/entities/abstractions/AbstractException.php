<?php


namespace vloop\problems\entities\abstractions;


use Throwable;

abstract class AbstractException extends \Exception
{
    abstract function errors(): array;
}