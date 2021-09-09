<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\ErrorsByEntity;
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
     * @return Problem[]
     */
    public function list(): array
    {
        $entities = [];
        $all = TableProblems::find()->all();
        foreach ($all as $item) {
            $entities[] = new ProblemSQL($item->id);
        }
        if (!$entities) {
            $entities[] = new ErrorsByEntity([
                "Not Found" => 'Не найдены проблемы'
            ]);
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
        if ($fields) {
            $record = new TableProblems($fields);
            try {
                if ($record->save()) {
                    return new ProblemSQL($record->id);
                } else {
                    return new ErrorsByEntity($record->getErrors());
                }
            } catch (StaleObjectException $e) {
                return new ErrorsByEntity([
                    $e->getName() => $e->getMessage()
                ]);
            } catch (Exception $e) {
                return new ErrorsByEntity([
                    $e->getName() => $e->getMessage()
                ]);
            } catch (NotInstantiableException $e) {
                return new ErrorsByEntity([
                    $e->getName() => $e->getMessage()
                ]);
            }
        }
        return new ErrorsByEntity($form->errors());
    }

    public function remove(Entity $entity): bool
    {
        return TableProblems::deleteAll(['id' => $entity->id()]);
    }
}