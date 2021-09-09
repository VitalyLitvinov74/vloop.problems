<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\Entities;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use yii\helpers\VarDumper;

class RestEntities extends EntitiesCollection
{
    private $origType;
    private $origin;
    private $needleField;

    public function __construct(Entities $entitiesList, string $entityType, array $needleFields = []) {
        $this->needleField = $needleFields;
        $this->origin = $entitiesList;
        $this->origType = $entityType;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        $all = $this->origin->list();
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

    public function remove(Entity $entity): bool
    {
        return $this->origin->remove($entity);
    }
}