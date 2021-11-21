<?php


namespace vloop\problems\entities\report;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;
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

    /***
     * @param Form $form
     * @return Entity
     * @throws NotSavedData
     * @throws NotValidatedFields
     */
    public function changeLineData(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = $this->record();
        $record->setAttributes($fields, false);
        if($record->save()){
            return $this;
        }
        throw new NotSavedData($record->getErrors(), 422);
    }

    public function remove(): void
    {
        TableReports::deleteAll(['id'=>$this->id()]);
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }
}