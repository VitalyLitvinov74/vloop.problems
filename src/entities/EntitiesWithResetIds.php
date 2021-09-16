<?php


namespace vloop\problems\entities;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class EntitiesWithResetIds implements Entities
{
    private $origin;

    public function __construct(Entities $entities) {
        $this->origin = $entities;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        return array_values($this->origin->list());
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     * @throws NotSavedRecord
     * @throws NotValidatedFields
     */
    public function add(Form $form): Entity
    {
        return $this->origin->add($form);
    }

    /**
     * @param int $id
     * @return Entity
     * @throws NotFoundHttpException
     */
    public function entity(int $id): Entity
    {
        if(isset($this->list()[$id])){
            return $this->list()[$id];
        }
        throw new NotFoundHttpException("Сущность не найдена.");
    }
}