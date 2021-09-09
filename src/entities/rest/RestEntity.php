<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use yii\helpers\VarDumper;

class RestEntity implements Entity
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
        if ($this->origin->notNull()) {
            return [
                'data' => [
                    "type" => $this->originType,
                    "id" => $this->id(),
                    "attributes" => $this->attributes()
                ]
            ];
        }
        return [
            'errors'=>$this->errors()
        ];
    }

    /**
     * @return array - преобразует вложенный массив с ошибками а одномерный
     */
    private function errors():array {
        $errors = $this->origin->printYourself();
        $retErrors = [];
        foreach ($errors as $attribute=>$errorsAttribute){
            if(is_array($errorsAttribute)){
                foreach ($errorsAttribute as $concreteError){
                    $retErrors[] = [
                        "title"=>$attribute,
                        "message"=> $concreteError
                    ];
                }
            }else{
                $retErrors[] = [
                    'title'=>$attribute,
                    'message'=> $errorsAttribute
                ];
            }

        }
        return $retErrors;
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

    public function notNull(): bool
    {
        return $this->origin->notNull();
    }
}