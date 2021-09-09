<?php


namespace vloop\problems\entities\abstractions\contracts;


interface Entities extends \Iterator
{
    /**
     * @return Entity[]
    */
    public function list(): array;

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity;

    public function remove(Entity $entity): bool ;

    /**
     * @return Entity - Return the current element
    */
    public function current();
}