<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\abstractions\Entities;
use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\abstractions\Problem;
use vloop\problems\entities\abstractions\Role;

class ProblemsByCriteriaForm implements Entities
{
    private $form;
    private $problems;

    public function __construct(Entities $problems, Form $form) {
        $this->form = $form;
        $this->problems = $problems;
    }

    /**
     * @return Entity[]
     */
    public function all(): array
    {

    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity
    {
        // TODO: Implement addFromInput() method.
    }

    public function oneByCriteria(array $criteria): Entity
    {
        // TODO: Implement oneByCriteria() method.
    }

    public function remove(Entity $entity): bool
    {
        // TODO: Implement remove() method.
    }
}