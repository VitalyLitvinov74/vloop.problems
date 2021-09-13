<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class JsonApiEntities implements Entities
{
    private $origType;
    private $origin;
    private $needleField;

    public function __construct(Entities $entitiesList, string $entityType, array $needleFields = [])
    {
        $this->needleField = $needleFields;
        $this->origin = $entitiesList;
        $this->origType = $entityType;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        return [
            'data' => $this->simpleList()
        ];
    }

    private function simpleList(): array
    {
        $all = $this->origin->list();
        $data = [];
        foreach ($all as $item) {
            $data[] = $this->restEntity($item)->printYourself()['data'];
        }
        return $data;
    }

    private function restEntity(Entity $entity): RestEntity
    {
        return new RestEntity(
            $entity,
            $this->origType,
            $this->needleField
        );
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     * @throws NotValidatedFields
     * @throws NotSavedRecord
     */
    public function add(Form $form): Entity
    {
        return $this->restEntity(
            $this->origin->add($form)
        );
    }

    public function entity(int $id): Entity
    {
        return $this->restEntity(
            $this->origin->entity($id)
        );
    }
}