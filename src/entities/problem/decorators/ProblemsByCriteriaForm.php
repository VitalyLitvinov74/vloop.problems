<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\problems\entities\problem\AbstractProblems;
use vloop\problems\entities\problem\ProblemSQL;
use vloop\problems\tables\TableProblems;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class ProblemsByCriteriaForm extends AbstractProblems
{
    private $form;

    public function __construct(Form $form) {
        $this->form = $form;
    }

    /**
     * @return Entity[]
     * @throws \vloop\entities\exceptions\NotValidatedFields
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
            $entities[$record->id] = new ProblemSQL($record->id);
        }
        return $entities;
    }

    /**
     * @param int $id
     * @return Entity
     * @throws NotFoundHttpException
     * @throws \vloop\entities\exceptions\NotValidatedFields
     * id не берутся с оригинала, т.к. тут наложены ограничения на выборку оригинала.
     */
    public function entity(int $id): Entity
    {
        if(isset($this->list()[$id])){
            return $this->list()[$id];
        }
        throw new NotFoundHttpException("Проблема не найдена");
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }
}