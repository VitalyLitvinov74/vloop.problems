<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\VloopException;
use vloop\problems\entities\errors\DefaultExceptionAsEntity;
use vloop\problems\entities\errors\ArrayErrorsAsEntity;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

/**
 * Проверяет выполнение кода на ошибки,
 * если ошибки есть возвращает их в подготовленном формате для REST
 */
class ExceprionsAsJsonApi implements Entities
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
     * @return Entity|OneEntityWithExceptions - Проблема которую нужно решить
     */
    public function add(Form $form): Entity
    {
        try {
            return new OneEntityWithExceptions(
                $this->origin->add($form)
            );
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
            return new OneEntityWithExceptions( //обрабатываем в декораторе ошибки которые могут возникнуть в одной сущности.
                $this->origin->entity($id)
            );
        }catch (NotFoundHttpException $exception){
            return new ErrorAsJsonApi(
                new DefaultExceptionAsEntity($exception->getName(), $exception->getMessage())
            );
        }catch (NotValidatedFields $exception){
            return $this->modelErrorsAsEntity($exception);
        }
    }

    private function modelErrorsAsEntity(VloopException $except)
    {
        return new ErrorAsJsonApi(
            new ArrayErrorsAsEntity($except->errors())
        );
    }
}