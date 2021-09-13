<?php


namespace vloop\problems\entities\problem;


use http\Exception\InvalidArgumentException;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\Problem;
use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\EntitiesCollection;
use vloop\problems\entities\ErrorsByEntity;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;
use vloop\problems\tables\TableProblems;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\di\NotInstantiableException;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

class ProblemsSQL extends AbstractProblems
{

    /**
     * @return Problem[]|ErrorsByEntity[]
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
}