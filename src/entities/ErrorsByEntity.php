<?php


namespace vloop\problems\entities;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;

class ErrorsByEntity implements Entity
{
    private $self;

    /**
     * @param array $self - ["error1"=>'message', "error2"=>"message2"]
     */
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