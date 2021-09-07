<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\Role;

class RestProblem implements Problem
{
    private $origin;
    private $needleFields;

    public function __construct(Entity $entity, array $needleFields)
    {
        $this->origin = $entity;
        $this->needleFields = $needleFields;
    }

    public function id(): int
    {
        return $this->origin->id();
    }

    public function printYourself(): array
    {
        $attributes = [];
        if ($this->notNull()) {
            $origArray = $this->origin->printYourself();
            foreach ($this->needleFields as $needleField) {
                if (array_key_exists($needleField, $origArray)) {
                    $attributes[$needleField] = $origArray[$needleField];
                }
            }
            return [
                "type" => "problem",
                "id" => $this->id(),
                "attributes" => $attributes
            ];
        }
        return $this->origin->printYourself();
    }

    public function changeLineData(Form $form): Entity
    {

    }

    /**
     * @param string $status - имя статутса.
     * @return Entity - печатает себя, с новым статусом.
     */
    public function changeStatus(string $status): Entity
    {
        // TODO: Implement changeStatus() method.
    }

    /**
     * добавляет пользователя к задаче
     * @param int $id - ид юзера
     * @param Role $userRoleInProblem
     * @return Entity - вернет себя же
     */
    public function attachUser(int $id, Role $userRoleInProblem): Entity
    {
        // TODO: Implement attachUser() method.
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
        // TODO: Implement detachUser() method.
    }

    public function notNull(): bool
    {
        return $this->origin->notNull();
    }
}