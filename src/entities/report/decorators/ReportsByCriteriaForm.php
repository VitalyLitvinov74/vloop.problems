<?php


namespace vloop\problems\entities\report\decorators;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\EntitiesCollection;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\tables\TableReports;

class ReportsByCriteriaForm extends EntitiesCollection
{
    private $form;
    private $origin;

    public function __construct(Entities $origin, Form $form) {
        $this->origin = $origin;
        $this->form = $form;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        $fiends = $this->form->validatedFields();
        if($fiends){
            TableReports::find()->where($fiends)->all();
        }
        return [new ErrorsByEntity($this->form->errors())];
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity
    {
        // TODO: Implement addFromInput() method.
    }

    public function remove(Entity $entity): bool
    {
        // TODO: Implement remove() method.
    }
}