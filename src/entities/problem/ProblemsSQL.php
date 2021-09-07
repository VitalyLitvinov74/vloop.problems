<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\tables\TableProblems;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\di\NotInstantiableException;
use yii\helpers\VarDumper;

class ProblemsSQL implements EntitiesList
{
    /**
     * @return Problem[]
     */
    public function all(): array
    {
        $all = TableProblems::find()->all();
        $entities = [];
        foreach ($all as $item) {
            $entities[] = new ProblemSQL($item->id);
        }
        return $entities;
    }

    /**
     * @param array $criteria
     * @return Problem
     */
    public function oneByCriteria(array $criteria): Entity
    {
        $record = TableProblems::find()->where($criteria)->one();
        if ($record) {
            return new ProblemSQL($record->id);
        }
        return new NullProblem(['problem' => 'Проблема не найдена.']);
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
                if($record->save()){
                    return new ProblemSQL($record->id);
                }else{
                    return new NullProblem($record->errors);
                }
            } catch (StaleObjectException $e) {
                return new NullProblem([
                    'title'=>$e->getName(),
                    'message'=>$e->getMessage()
                ]);
            } catch (Exception $e) {
                return new NullProblem([
                    'title' => $e->getName(),
                    'message' => $e->getMessage()
                ]);
            } catch (NotInstantiableException $e){
                return new NullProblem([
                    'title'=> $e->getName(),
                    'message'=>$e->getMessage()
                ]);
            }
        }
        return new NullProblem($form->errors());
    }

    public function remove(Entity $entity): bool
    {
        return TableProblems::deleteAll(['id' => $entity->id()]);
    }
}