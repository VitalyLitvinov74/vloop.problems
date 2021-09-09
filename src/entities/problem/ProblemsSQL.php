<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\abstractions\Problem;
use vloop\problems\entities\abstractions\Entities;
use vloop\problems\entities\NullEntity;
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
                if($record->save()){
                    return new ProblemSQL($record->id);
                }else{
                    return new NullEntity($record->errors);
                }
            } catch (StaleObjectException $e) {
                return new NullEntity([
                    'title'=>$e->getName(),
                    'message'=>$e->getMessage()
                ]);
            } catch (Exception $e) {
                return new NullEntity([
                    'title' => $e->getName(),
                    'message' => $e->getMessage()
                ]);
            } catch (NotInstantiableException $e){
                return new NullEntity([
                    'title'=> $e->getName(),
                    'message'=>$e->getMessage()
                ]);
            }
        }
        return new NullEntity($form->errors());
    }

    public function remove(Entity $entity): bool
    {
        return TableProblems::deleteAll(['id' => $entity->id()]);
    }
}