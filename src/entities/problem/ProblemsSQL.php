<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\abstractions\Problem;
use vloop\problems\entities\abstractions\Entities;
use vloop\problems\tables\TableProblems;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\di\NotInstantiableException;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class ProblemsSQL implements Entities
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
        $exception = new NotFoundHttpException('Проблема не найдена');
        return new NullProblem([
            $exception->getName() => [$exception->getMessage()]
        ]);
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

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}