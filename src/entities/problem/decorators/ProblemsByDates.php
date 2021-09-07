<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\tables\TableProblems;

class ProblemsByDates implements EntitiesList
{
    private $origin;
    private $dateForm;

    /**
     * ProblemsByDates constructor.
     * @param EntitiesList $origin - первоначаьлный список
     * @param Form $dateForm - форма в которую были переданы данные
     */
    public function __construct(EntitiesList $origin, Form $dateForm) {
        $this->dateForm = $dateForm;
        $this->origin = $origin;
    }

    /**
     * @return Entity[]
     */
    public function all(): array
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