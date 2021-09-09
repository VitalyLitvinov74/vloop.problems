<?php


namespace vloop\problems\entities\abstractions\contracts;


interface Form
{
    public function validatedFields(): array;

    /**
     * @return array - ошибки валидации.
     * в формате "field" => "error"
    */
    public function errors(): array;
}