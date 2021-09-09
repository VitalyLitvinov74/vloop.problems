<?php


namespace vloop\problems\entities\report;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\entities\abstractions\contracts\Report;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\tables\TableReports;

class ReportSQL implements Entity
{

    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function printYourself(): array
    {
        return $this->record()->toArray();
    }

    private $tb = false;

    private function record()
    {
        if ($this->tb !== false) {
            return $this->tb;
        }
        $this->tb = TableReports::find()->where(['id' => $this->id()])->one();
        return $this->tb;
    }

    public function changeLineData(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = $this->record();
        if ($fields) {
            $record->setAttributes($fields, false);
            if($record->save()){
                return $this;
            }
            return new ErrorsByEntity($record->getErrors());
        }
        return new ErrorsByEntity($form->errors());
    }

    public function notNull(): bool
    {
        return false;
    }
}