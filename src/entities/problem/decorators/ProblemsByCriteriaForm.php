<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\abstractions\Entities;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\abstractions\Problem;
use vloop\problems\entities\abstractions\Role;
use vloop\problems\entities\problem\NullProblem;
use vloop\problems\entities\problem\ProblemSQL;
use vloop\problems\tables\TableProblems;
use yii\helpers\VarDumper;

class ProblemsByCriteriaForm extends EntitiesCollection
{
    private $form;
    protected $origin;

    public function __construct(Entities $origin, Form $form) {
        $this->form = $form;
        $this->origin = $origin;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        $fields = $this->form->validatedFields();
        if($fields){
            $all = TableProblems::find()->where($fields)->all();
            return $this->entities($all);
        }
        return [];
    }

    /**
     * @param TableProblems[] $activeRecords
     * @return Entity[]
     */
    private function entities(array $activeRecords): array{
        $entities = [];
        foreach ($activeRecords as $record){
            $entities[] = new ProblemSQL($record->id);
        }
        return $entities;
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