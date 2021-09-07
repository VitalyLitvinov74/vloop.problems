<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\Role;

class ProblemByCriteriaForm implements Problem
{
    private $form;
    private $problems;

    public function __construct(EntitiesList $problems, Form $form) {
        $this->form = $form;
        $this->problems = $problems;
    }

    private function entity(): Problem{
        $fields = $this->form->validatedFields();
        if($fields){
            return $this->problems->oneByCriteria($fields);
        }
        return new NullProblem([]);
    }

    public function id(): int
    {
        return $this->entity()->id();
    }

    public function printYourself(): array
    {
        return $this->entity()->printYourself();
    }

    public function changeLineData(Form $form): Entity
    {
        return $this->entity()->changeLineData($form);
    }

    public function notNull(): bool
    {
        return $this->entity()->notNull();
    }

    /**
     * добавляет пользователя к задаче
     * @param int $id - ид юзера
     * @param Role $userRoleInProblem
     * @return Entity - вернет себя же
     */
    public function attachUser(int $id, Role $userRoleInProblem): Entity
    {
        return $this->entity()->attachUser($id, $userRoleInProblem);
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
        return $this->entity()->detachUser($id);
    }
}