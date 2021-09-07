<?php


namespace vloop\problems\entities\report;


use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Report;
use vloop\problems\tables\TableReports;

class ReportsSQL implements EntitiesList
{

    /**
     * @return Entity[]
     */
    public function all(): array
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
     */
    public function addFromInput(Form $form): Entity
    {
        $fields = $form->validatedFields();
        if($fields){
            $record = new TableReports();
            $record->load($fields, '');
            $record->save();
            return new ReportSQL($record->id);
        }
        return new NullReport($form->errors());
    }

    /**
     * @param array $criteria
     * @return Report
     */
    public function oneByCriteria(array $criteria): Entity
    {
        $record = TableReports::find()
            ->select('id')
            ->where($criteria)
            ->one();
        if($record){
            return new ReportSQL($record->id);
        }
        return new NullReport([
            'report'=>'Отчет не найден.'
        ]);
    }

    public function remove(Entity $entity): bool
    {
        return TableReports::deleteAll(['id'=>$entity->id()]);
    }
}