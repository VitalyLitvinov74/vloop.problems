<?php


namespace vloop\problems\entities\forms\criteria;


use vloop\problems\entities\abstractions\AbstractForm;
use yii\helpers\VarDumper;

class CriteriaProblemsByDates extends AbstractForm
{
    public $period_of_execution;
    public $time_of_creation;

    protected $method = 'post';

    public function rules()
    {
        return [
            [['time_of_creation'], 'required'],
            [['time_of_creation', 'period_of_execution'], 'integer', 'max'=>2147483647],
            ['period_of_execution', 'default', 'value' => 2147483647]
        ];
    }

    public function validatedFields(): array
    {
        $fields = parent::validatedFields();
        $exec = (int)$fields['period_of_execution'];
        $timeCreation = (int) $fields['time_of_creation'];
        return [
            'and',
            ['>=', 'time_of_creation', $timeCreation],
            ['<=', 'period_of_execution', $exec] //задано конкретное время
        ];
    }
}