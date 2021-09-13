<?php


namespace vloop\problems\entities\abstractions\contracts;


use vloop\problems\entities\exceptions\NotValidatedFields;

interface Form
{
    /**
     * @return array
     * @throws NotValidatedFields
     */
    public function validatedFields(): array;
}