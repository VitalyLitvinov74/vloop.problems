<?php


namespace vloop\problems\entities\forms\criteria;


use vloop\problems\entities\abstractions\AbstractForm;

class CriteriaProblemsByDates extends AbstractForm
{
    public $period_of_execution;
    public $time_of_creation;

    protected $method = 'post';

    public function rules()
    {
        return [
            [['time_of_creation'], 'required'],
            [['time_of_creation', 'period_of_execution'], 'integer'],
            //точка старта компьютерной эпохи
            ['period_of_execution', 'default', 'value' => 1630849778]
        ];
    }

    public function validatedFields(): array
    {
        $fields = parent::validatedFields();
        $exec = (int)$fields['period_of_execution'];
        $timeCreation = (int) $fields['time_of_creation'];
        if($exec > 1630849778){ //точка старта компьютерной эпохи
            return [
                'and',
                ['>=', 'time_of_creation', $timeCreation],
                ['=<', 'period_of_execution', $exec] //задано конкретное время
            ];
        }
        return [
            'and',
            ['>=', 'time_of_creation', $timeCreation],
            ['>=', 'period_of_execution', $exec] //время окончания задачи должно быть больше чем время старта комп. эпохи
        ];
    }
}