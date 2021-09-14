<?php


namespace vloop\problems\entities\report\decorators;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\EntitiesCollection;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\entities\exceptions\NotValidatedFields;
use vloop\problems\entities\report\ReportSQL;
use vloop\problems\tables\TableReports;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class ReportsByCriteriaForm implements Entities
{
    private $form;
    private $origin;

    public function __construct(Entities $origin, Form $form) {
        $this->origin = $origin;
        $this->form = $form;
    }

    /**
     * @return Entity[]
     * @throws NotValidatedFields
     */
    public function list(): array
    {
        $fiends = $this->form->validatedFields();
        $records = TableReports::find()->where($fiends)->all();
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
    public function add(Form $form): Entity
    {
        return $this->origin->add($form);
    }

    /**
     * @param int $id
     * @return Entity
     * @throws NotFoundHttpException
     * @throws NotValidatedFields
     */
    public function entity(int $id): Entity
    {
        $fields = $this->form->validatedFields();
        $exist = TableReports::find()->where($fields)->andWhere(['id'=>$id])->exists();
        if($exist){
            return new ReportSQL($id);
        }
        throw new NotFoundHttpException("Отчет не найден.");
    }
}