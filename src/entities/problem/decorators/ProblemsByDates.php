<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\tables\TableProblems;

class ProblemsByDates implements Entities
{
    private $origin;
    private $dateForm;

    /**
     * ProblemsByDates constructor.
     * @param Entities $origin - первоначаьлный список
     * @param Form $dateForm - форма в которую были переданы данные
     */
    public function __construct(Entities $origin, Form $dateForm) {
        $this->dateForm = $dateForm;
        $this->origin = $origin;
    }

    /**
     * @return Entity[]
     */
    public function list(): array
    {
        $fields = $this->dateForm->validatedFields();
        if($fields){
            $criteria = $this->criteria($fields);
            $all = TableProblems::find()->where($criteria)->all();
            return $all;
        }
        return [];

    }

    private function criteria(array $fields){
        $exec = $fields['period_of_execution'];
        $timeCreation = $fields['time_of_creation'];
        if($exec > 1630849778){ //точка старта компьютерной эпохи
            return [
                'and',
                ['>', 'time_of_creation', $timeCreation],
                ['<', 'period_of_execution', $exec]
            ];
        }
        return ['>', 'time_of_creation', $timeCreation];
    }

    /**
     * @param Form $form - форма, которая выдает провалидированные данные
     * @return Entity - Проблема которую нужно решить
     */
    public function addFromInput(Form $form): Entity
    {
        return $this->origin->addFromInput($form);
    }

    public function oneByCriteria(array $criteria): Entity
    {
        return $this->origin->oneByCriteria($criteria);
    }

    public function remove(Entity $entity): bool
    {
        return $this->origin->remove($entity);
    }
}