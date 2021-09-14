<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;

class ErrorAsJsonApi implements Entity
{
    private $origin;

    public function __construct(Entity $origin)
    {
        $this->origin = $origin;
    }

    public function id(): int
    {
        return $this->origin->id();
    }

    public function printYourself(): array
    {
        return [
            'errors' => $this->origin->printYourself()
        ];
    }

    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    public function remove(): void
    {
        $this->origin->remove();
    }
}