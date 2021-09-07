<?php


namespace vloop\problems\entities\interfaces;


interface Entity
{
    public function id(): int;

    public function printYourself(): array;

    public function changeLineData(Form $form): Entity;

    public function notNull(): bool;
}