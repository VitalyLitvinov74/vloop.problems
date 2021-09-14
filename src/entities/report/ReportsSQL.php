<?php


namespace vloop\problems\entities\report;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Report;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
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
     * @throws NotSavedRecord
     */
    public function add(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = new TableReports($fields);
        if($record->save()){
            return new ReportSQL($record->id);
        }
        throw new NotSavedRecord($record->getErrors());
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
}