<?php


namespace vloop\problems\entities\forms\criteria;


use vloop\problems\entities\abstractions\AbstractForm;

class CriteriaReportByProblemId extends AbstractForm
{
    public $problem_id;
//    public $user_id;

    public function rules()
    {
        return [
            ['problem_id', 'required'],
            ['problem_id', 'integer'],
        ];
    }
}