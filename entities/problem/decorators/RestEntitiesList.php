<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;

class RestEntitiesList implements EntitiesList
{

    private $origin;

    public function __construct(EntitiesList $list) {
        $this->origin = $list;
    }

    /**
     * @return Entity[]
     */
    public function all(): array
    {
        $entities = $this->origin->all();
        $restArr = [];
        foreach ($entities as $entity){
            $restArr[] = $entity->printYourself();
        }
        return [
            "data"=>[
                $restArr
            ]
        ];
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity
    {
        return $this->origin->addFromInput($form);
    }

    public function oneByCriteria(array $criteria): Entity
    {
        return $this->origin->oneByCriteria($criteria);
    }

    public function remove(Entity $entity): bool
    {
        return $this->origin->remove($entity);
    }
}