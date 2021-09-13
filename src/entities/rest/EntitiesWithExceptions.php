<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\VloopException;
use vloop\problems\entities\errors\ErrorForException;
use vloop\problems\entities\errors\ModelErrorsAsEntity;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

/**
 * Проверяет выполнение кода на ошибки,
 * если ошибки есть возвращает их в подготовленном формате для REST
 */
class EntitiesWithExceptions implements Entities
{
    private $origin;

    public function __construct(Entities $orig)
    {
        $this->origin = $orig;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        try {
            return $this->origin->list();
        } catch (NotSavedRecord $exception) {
            return $this->modelErrorsAsEntity($exception)->printYourself();
        } catch (NotValidatedFields $exception) {
            return $this->modelErrorsAsEntity($exception)->printYourself();
        }
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function add(Form $form): Entity
    {
        try {
            return $this->origin->add($form);
        } catch (NotSavedRecord $exception) {
            return $this->modelErrorsAsEntity($exception);
        } catch (NotValidatedFields $exception) {
            return $this->modelErrorsAsEntity($exception);
        }
    }

    /**
     * @param int $id
     * @return Entity
     */
    public function entity(int $id): Entity
    {
        try{
            return $this->origin->entity($id);
        }catch (NotFoundHttpException $exception){
            return new RestError(
                new ErrorForException($exception->getName(), $exception->getMessage())
            );
        }catch (NotValidatedFields $exception){
            return $this->modelErrorsAsEntity($exception);
        }
    }

    private function modelErrorsAsEntity(VloopException $except)
    {
        return new RestError(
            new ModelErrorsAsEntity($except->errors())
        );
    }


}