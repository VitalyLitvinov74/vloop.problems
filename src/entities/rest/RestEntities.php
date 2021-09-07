<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;

class RestEntities implements EntitiesList
{
    private $origType;
    private $origin;
    private $needleField;

    public function __construct(EntitiesList $entitiesList,string $entityType, array $needleFields = []) {
        $this->needleField = $needleFields;
        $this->origin = $entitiesList;
        $this->origType = $entityType;
    }

    /**
     * @return Entity[]
     */
    public function all(): array
    {
        $all = $this->origin->all();
        $data = [];
        foreach ($all as $item){
            $restItem = new RestEntity(
                $item,
                $this->origType,
                $this->needleField
            );
            $data[] = $restItem->printYourself()['data'];
        }
        return [
            'data'=>$data
        ];
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity
    {
        return new RestEntity(
            $this->origin->addFromInput($form),
            $this->origType
        );
    }

    public function oneByCriteria(array $criteria): Entity
    {
        return new RestEntity(
            $this->origin->oneByCriteria($criteria),
            $this->origType
        );
    }

    public function remove(Entity $entity): bool
    {
        return $this->origin->remove($entity);
    }
}