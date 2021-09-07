<?php


namespace vloop\problems\entities\forms\criteria;


use vloop\problems\entities\forms\AbstractForm;

class CriteriaProblemsByDates extends AbstractForm
{
    public $period_of_execution;
    public $time_of_create;

    protected $method = 'post';

    public function rules()
    {
        return [
            [['time_of_created'], 'required'],
            [['time_of_created', 'period_of_execution'], 'int'],
            //точка старта компьютерной эпохи
            ['period_of_execution', 'default', 'value' => 1630849778]
        ];
    }
}