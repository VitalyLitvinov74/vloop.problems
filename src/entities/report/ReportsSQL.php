<?php


namespace vloop\problems\entities\report;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotSavedData;
use vloop\entities\exceptions\NotValidatedFields;
use vloop\problems\tables\TableReports;
use yii\web\NotFoundHttpException;

class ReportsSQL implements Entities
{

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        $records = TableReports::find()->select('id')->all();
        $entities = [];
        foreach ($records as $record){
            $entities[$record->id] = new ReportSQL($record->id);
        }
        return $entities;
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     * @throws NotValidatedFields
     * @throws NotSavedData
     */
    public function add(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = new TableReports($fields);
        if($record->save()){
            return new ReportSQL($record->id);
        }
        throw new NotSavedData($record->getErrors(), 422);
    }

    /**
     * @param int $id
     * @return Entity
     * @throws NotFoundHttpException
     */
    public function entity(int $id): Entity
    {
        $record = TableReports::find()->where(['id'=>$id])->exists();
        if($record){
            return new ReportSQL($id);
        }
        throw new NotFoundHttpException('Отчет не найден.');
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }
}