<?php


namespace vloop\problems\entities\errors;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;

class DefaultExceptionAsEntity implements Entity
{
    private $message;
    private  $title;

    public function __construct(string $title, string $message) {
        $this->message = $message;
        $this->title = $title;
    }

    public function id(): int
    {
        return 0;
    }

    public function printYourself(): array
    {
        return [
            'title'=>$this->title,
            'description'=>$this->message
        ];
    }

    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    public function remove(): void
    {
        // not action
    }
}