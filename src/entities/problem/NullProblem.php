<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\Role;

class NullProblem implements Problem
{
    private $self;

    public function __construct(array $self) {
        $this->self = $self;
    }

    public function id(): int
    {
        return 0;
    }

    public function printYourself(): array
    {
        return $this->self;
    }

    public function changeLineData(Form $form): Entity
    {
        return $this;
    }

    public function notNull(): bool
    {
        return false;
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