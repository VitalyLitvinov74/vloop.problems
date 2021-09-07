<?php


namespace vloop\problems\entities\forms\inputed;


use vloop\problems\entities\forms\AbstractForm;
use vloop\problems\entities\interfaces\Form;
use Yii;
use yii\base\Model;

class AddProblemForm extends AbstractForm
{
    public $author_id;
    public $status;
    public $description;
    public $period_of_execution;
    public $time_of_creation;

    protected $method = 'post';

    public function rules()
    {
        return [
            [['author_id', 'description'], 'required'],
            ['time_of_creation', 'default', 'value' => time()],
            ['period_of_execution', 'default', 'value' => 1630849778],//точка старта компьютерной эпохи
            [['status', 'description'], 'string'],
            [['author_id', 'period_of_execution', 'time_of_creation'],'integer']
        ];
    }
}