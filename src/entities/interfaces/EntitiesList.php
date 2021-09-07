<?php


namespace vloop\problems\entities\interfaces;


interface EntitiesList
{
    /**
     * @return Entity[]
    */
    public function all(): array;

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity;

    public function oneByCriteria(array $criteria): Entity;

    public function remove(Entity $entity): bool ;
}