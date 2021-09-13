<?php


namespace vloop\problems\entities\abstractions\contracts;


use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;

interface Entity
{
    public function id(): int;

    public function printYourself(): array;

    /**
     * @param Form $form
     * @return Entity
     */
    public function changeLineData(Form $form): Entity;

    public function remove(): void;
}