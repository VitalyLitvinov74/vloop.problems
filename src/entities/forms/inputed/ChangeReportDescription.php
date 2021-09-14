<?php


namespace vloop\problems\entities\forms\inputed;


use vloop\problems\entities\abstractions\AbstractForm;

class ChangeReportDescription extends AbstractForm
{
    public $description;

    public function rules()
    {
        return [
            ['description','required'],
            ['description', 'string']
        ];
    }
}