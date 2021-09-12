<?php


namespace vloop\problems\entities\abstractions\contracts;


interface Form
{
    public function validatedFields(): array;
}