<?php


namespace vloop\problems\entities\problem;


use http\Exception\InvalidArgumentException;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\entities\exceptions\ValidateFieldsException;
use vloop\problems\tables\TableProblems;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\di\NotInstantiableException;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class ProblemsSQL extends EntitiesCollection
{

    /**
     * @return Problem[]|ErrorsByEntity[]
     */
    public function list(): array
    {
        $entities = [];
        $all = TableProblems::find()->all();
        foreach ($all as $item) {
            $entities[] = new ProblemSQL($item->id);
        }
        return $entities;
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     * @throws ValidateFieldsException
     */
    public function addFromInput(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = new TableProblems($fields);
        if($record->save()){
            return new ProblemSQL($record->id);
        }
        throw new ValidateFieldsException($record->getErrors(), 422);
    }

    public function remove(Entity $entity): bool
    {
        return TableProblems::deleteAll(['id' => $entity->id()]);
    }
}