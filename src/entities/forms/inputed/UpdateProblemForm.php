<?php


namespace vloop\problems\entities\forms\inputed;


use vloop\entities\yii2\AbstractForm;

class UpdateProblemForm extends AbstractForm
{
    public $status;
    public $description;
    public $period_of_execution;

    protected $method = 'post';

    public function rules()
    {
        return [
            [['description'], 'required'],
            ['period_of_execution', 'default', 'value' => 1630849778],//точка старта компьютерной эпохи
            ['status', 'default', 'value'=> "Новая"],
            [['status', 'description'], 'string'],
            [['period_of_execution'],'integer']
        ];
    }
}