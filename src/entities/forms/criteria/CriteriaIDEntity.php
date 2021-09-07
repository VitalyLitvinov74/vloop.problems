<?php


namespace vloop\problems\entities\forms\criteria;


use vloop\problems\entities\forms\AbstractForm;

class CriteriaIDEntity extends AbstractForm
{
    public $id;

    public function rules(){
        return [
            ['id', 'required'],
            ['id', 'integer']
        ];
    }
}