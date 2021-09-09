<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\EntitiesCollection;
use yii\helpers\VarDumper;

class RestEntities extends EntitiesCollection
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
        $all = $this->origin; //здесь либо список ошибок либо список сущностей.
        $data = [];
        foreach ($all as $item) {
            $restItem = $this->restEntity($item);
            $data[] = $restItem->printYourself()['data'];
        }
        return ['data'=>$data];
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
     */
    public function addFromInput(Form $form): Entity
    {
        return $this->restEntity(
            $this->origin->addFromInput($form)
        );
    }

    public function remove(Entity $entity): bool
    {
        return $this->origin->remove($entity);
    }

    public function valid()
    {
        return isset($this->origin->list()[$this->position]);
    }

    public function current()
    {
        return $this->restEntity($this->origin->current());
    }
}