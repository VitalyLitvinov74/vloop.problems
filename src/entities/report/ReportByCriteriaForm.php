<?php


namespace vloop\problems\entities\report;


use vloop\problems\entities\abstractions\Entities;
use vloop\problems\entities\abstractions\Entity;
use vloop\problems\entities\abstractions\Form;
use vloop\problems\entities\abstractions\Problem;
use vloop\problems\entities\abstractions\Report;
use vloop\problems\tables\TableReports;

class ReportByCriteriaForm implements Report
{
    private $form;
    private $list;
    private $needleFindBy;

    /**
     * @param ReportsSQL|Entities $list - список отчетов
     * @param Form $form - входные данные с критериями поиска
     */
    public function __construct(Entities $list, Form $form)
    {
        $this->list = $list;
        $this->form = $form;
    }

    private function entity()
    {
        $form = $this->form;
        $criteria = $form->validatedFields();
        if ($criteria) {
            return $this->list->oneByCriteria($criteria);
        }
        return new NullReport($form->errors());
    }

    public function id(): int
    {
        return $this->entity()->id();
    }

    public function printYourself(): array
    {
        return $this->entity()->printYourself();
    }

    public function attachToProblem(Problem $problem): Entity
    {
        return $this->entity()->attachToProblem($problem);
    }

    public function changeLineData(Form $form): Entity
    {
        return $this->entity()->changeLineData($form);
    }
}