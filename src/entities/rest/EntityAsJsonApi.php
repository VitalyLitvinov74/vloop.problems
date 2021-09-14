<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\exceptions\NotValidatedFields;
use yii\helpers\VarDumper;

class EntityAsJsonApi implements Entity
{
    private $origin;
    private $needleFields;
    private $originType;

    /**
     * RestEntity constructor.
     * @param Entity $entity - сущность которую надо преобразовать в jsonapi
     * @param string $entityType - тип сущности
     * @param array $needleAttributes - атрибуты которые можно выводить
     */
    public function __construct(Entity $entity, string $entityType, array $needleAttributes = [])
    {
        $this->needleFields = $needleAttributes;
        $this->origin = $entity;
        $this->originType = $entityType;
    }

    public function id(): int
    {
        return $this->origin->id();
    }

    public function printYourself(): array
    {
        return [
            'data' => [
                "type" => $this->originType,
                "id" => $this->id(),
                "attributes" => $this->attributes()
            ]
        ];
    }

    private function attributes()
    {
        $origArray = $this->origin->printYourself();
        $attributes = [];
        if ($this->needleFields) {
            foreach ($this->needleFields as $needleField) {
                if (array_key_exists($needleField, $origArray)) {
                    $attributes[$needleField] = $origArray[$needleField];
                }
            }
        } else {
            $attributes = $origArray;
            unset($attributes['id']);
        }

        return $attributes;
    }

    public function changeLineData(Form $form): Entity
    {
        $this->origin = $this->origin->changeLineData($form);
        return $this;
    }

    public function remove(): void
    {
        $this->origin->remove();
    }
}