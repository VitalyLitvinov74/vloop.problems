<?php


namespace vloop\problems\entities\errors;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\VloopException;
use yii\helpers\VarDumper;

/**
 * Ошибки модели Yii в виде сущности.
*/
class ModelErrorsAsEntity implements Entity
{
    private $allErrors;

    public function __construct(array $errors) {
        $this->allErrors = $errors;
    }

    public function id(): int
    {
        return 0;
    }

    public function printYourself(): array
    {
        $answer =  [];
        foreach ($this->allErrors as $attribute=>$errors){
            foreach ($errors as $concreteErrorDescription){
                $answer[] = [
                    "title"=>$attribute,
                    'description'=>$concreteErrorDescription
                ];
            }
        }
        return $answer;
    }

    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    public function remove(): void
    {
        //not action
    }
}