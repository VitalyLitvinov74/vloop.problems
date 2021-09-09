<?php


namespace vloop\problems\entities\problem;

use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\abstractions\Problem;
use vloop\problems\entities\abstractions\Role;
use vloop\problems\entities\NullEntity;
use vloop\problems\entities\report\NullReport;
use vloop\problems\tables\TableProblems;
use vloop\problems\tables\TableProblemsUsers;
use yii\helpers\VarDumper;

class ProblemSQL implements Problem
{

    private $id;
    private $record = false;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function printYourself(): array
    {
        return $this->record()->toArray();
    }

    /**
     * @return null|array|bool|TableProblems|\yii\db\ActiveRecord
     */
    private function record(){
        if($this->record !== false){
            return $this->record;
        }
        $this->record = TableProblems::find()->where(['id'=>$this->id()])->one();
        return $this->record;
    }

    public function changeLineData(Form $form): Entity
    {
        $record = $this->record();
        $fields = $form->validatedFields();
        if($fields){
            $record->setAttributes($fields, false);
            if($record->save()) {
                return $this;
            }
            return new NullEntity($record->getErrors());
        }
        return new NullEntity($form->errors());
    }

    public function notNull(): bool
    {
        return true;
    }

    /**
     * добавляет пользователя к задаче
     * @param int $id - ид юзера
     * @param Role $userRoleInProblem
     * @return Entity - вернет себя же
     */
    public function attachUser(int $id, Role $userRoleInProblem): Entity
    {
        return $this;
    }

    /**
     * открепляет пользователя от задачи,
     * будь это пользователь хоть бригадиром, хоть исполнителем.
     * автора удалить нельзя.
     * @param int $id
     * @return Entity - вернет себя же, нового
     */
    public function detachUser(int $id): Entity
    {
        return $this;
    }
}