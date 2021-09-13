<?php


namespace vloop\problems\entities\abstractions\contracts;


interface VloopException
{
    public function errors(): array;
}