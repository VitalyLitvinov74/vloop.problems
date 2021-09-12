<?php


namespace vloop\problems\entities\cache;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\exceptions\ValidateFieldsException;
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
}