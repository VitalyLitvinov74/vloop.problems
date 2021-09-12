<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\entities\abstractions\contracts\Role;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\entities\exceptions\ValidateFieldsException;
use vloop\problems\entities\problem\ProblemSQL;
use vloop\problems\tables\TableProblems;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

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
        $all = TableProblems::find()->where($fields)->all();
        return $this->entities($all);
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