<?php


namespace vloop\problems\entities\cache;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

/**
 * Декоратор, который может кешировать работу коллекций.
 */
class CachedEntities implements Entities
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
    public function add(Form $form): Entity
    {
        return $this->origin->add($form);
    }

    /**
     * @param int $id
     * @return Entity
     */
    public function entity(int $id): Entity
    {
        static $entity;
        if($entity){
            return $entity;
        }
        $entity = $this->origin->entity($id);
        return $entity;
    }
}