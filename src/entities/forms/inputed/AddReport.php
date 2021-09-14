<?php


namespace vloop\problems\entities\forms\inputed;


use vloop\problems\entities\abstractions\AbstractForm;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\base\Model;

class AddReport extends AbstractForm
{
    public $user_id;
    public $problem_id;
    public $description;

    public function rules()
    {
        return [
            [['user_id', 'problem_id', 'description'], 'required'],
            [['user_id', 'problem_id'], 'integer'],
            ['description', 'string']
        ];
    }
}