<?php


namespace vloop\problems\entities\cache;


use vloop\problems\entities\abstractions\Entities;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\problem\NullProblem;
use yii\helpers\VarDumper;

/**
 * Декоратор, который может кешировать работу коллекций.
 */
class CachedEntities extends EntitiesCollection
{

    private $origin;

    public function __construct(Entities $origin)
    {
        $this->origin = $origin;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        /**@var array $list */
        static $list = false;
        if ($list !== false) {
            return $list;
        }
        $list = $this->origin->list();
        return $list;
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity
    {
        return $this->origin->addFromInput($form);
    }

    public function remove(Entity $entity): bool
    {
        return $this->origin->remove($entity);
    }

    public function current()
    {
        return $this->origin->current();
    }
}