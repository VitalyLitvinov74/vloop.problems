<?php


namespace vloop\problems\entities;


use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;

class NullEntity implements Entity
{
    private $self;
    public function __construct(array $self) {
        $this->self = $self;
    }

    public function id(): int
    {
        return 0;
    }

    public function printYourself(): array
    {
        return $this->self;
    }

    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    public function notNull(): bool
    {
        return  false;
    }
}