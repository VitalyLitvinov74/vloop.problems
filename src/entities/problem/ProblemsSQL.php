<?php


namespace vloop\problems\entities\problem;

use vloop\entities\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\tables\TableProblems;
use yii\web\NotFoundHttpException;

class ProblemsSQL extends AbstractProblems
{

    /**
     * @return Problem[]
     */
    public function list(): array
    {
        $entities = [];
        $all = TableProblems::find()->all();
        foreach ($all as $item) {
            $entities[] = new ProblemSQL($item->id);
        }
        return $entities;
    }

    public function entity(int $id):Entity
    {
        $record = TableProblems::find()->where(['id'=>$id])->one();
        if($record){
            return new ProblemSQL($record->id);
        }
        throw new NotFoundHttpException("Проблема не найдена.");
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }
}