<?php


namespace vloop\problems\entities\abstractions\contracts;


use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\web\NotFoundHttpException;

interface Entities
{
    /**
     * @return Entity[]
    */
    public function list(): array;

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     * @throws NotSavedRecord
     * @throws NotValidatedFields
     */
    public function add(Form $form): Entity;

    /**
     * @param int $id
     * @return Entity
     * @throws NotFoundHttpException
     */
    public function entity(int $id): Entity;
}