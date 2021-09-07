<?php


namespace vloop\problems\entities\forms\inputed;


use vloop\problems\entities\forms\AbstractForm;
use Yii;

class InputsForChangeReport extends AbstractForm
{
    public $newDescription;

    protected $method = 'post';

    public function rules()
    {
        return [
            ['newDescription', 'required'],
            ['newDescription', 'string']
        ];
    }
}