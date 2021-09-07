<?php


namespace vloop\problems\entities\problem\decorators;


use vloop\problems\entities\interfaces\EntitiesList;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\Role;
use vloop\problems\entities\problem\ProblemsSQL;
/**
 * характеризуется следующими параметрами:
 * 1. ид проблемы из формы поиска
 * 2. списоком всех проблем
 *
 *
 * Проблема из списка по ИД в форме
*/
class ProblemByForm implements Problem
{
    private $form;
    private $list;

    public function __construct(Form $form, ProblemsSQL $list) {
        $this->list = $list;
        $this->form = $form;
    }

    private function problem(): Problem{
        $fields = $this->form->validatedFields();
        return $this->list->oneByCriteria(['id'=>$fields['id']]);
    }

    public function id(): int
    {
        $this->problem()->id();
    }

    public function printYourself(): array
    {
        // TODO: Implement printYourself() method.
    }

    public function changeStatus(string $status): bool
    {
        // TODO: Implement changeStatus() method.
    }

    /**
     * добавляет пользователя к задаче
     * @param int $id - ид юзера
     * @param Role $userRoleInProblem
     */
    public function attachUser(int $id, Role $userRoleInProblem)
    {
        // TODO: Implement attachUser() method.
    }

    /**
     * открепляет пользователя от задачи,
     * будь это пользователь хоть бригадиром, хоть исполнителем.
     * автора удалить нельзя.
     * @param int $id
     */
    public function detachUser(int $id)
    {
        // TODO: Implement detachUser() method.
    }
}