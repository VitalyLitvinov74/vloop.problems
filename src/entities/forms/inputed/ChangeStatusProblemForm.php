<?php


namespace vloop\problems\entities\forms\inputed;


use vloop\problems\entities\forms\AbstractForm;

class ChangeStatusProblemForm extends AbstractForm
{
    public $status;

    protected $method = 'post';

    public function rules()
    {
        return [
            ['status', 'required'],
            ['status', 'string']
        ];
    }
}