<?php


namespace vloop\problems\entities\report;


use vloop\problems\entities\interfaces\Entity;
use vloop\problems\entities\interfaces\Form;
use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\Report;
use vloop\problems\tables\TableReports;

class ReportSQL implements Report
{

    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function attachToProblem(Problem $problem): Entity
    {
        $report = TableReports::find()->where(['id' => $this->id()])->one();
        $report->problem_id = $problem->id();
        $report->save();
        return $this;
    }

    public function printYourself(): array
    {
        return $this->record()->toArray();
    }

    private $tb = false;

    private function record()
    {
        if ($this->tb !== false) {
            return $this->tb;
        }
        $this->tb = TableReports::find()->where(['id' => $this->id()])->one();
        return $this->tb;
    }

    public function changeLineData(Form $form): Entity
    {
        $fields = $form->validatedFields();
        if ($fields) {
            $record = $this->record();
            $record->load($fields, '');
            $record->save();
            return $this;
        }
        return new NullReport($form->errors());
    }
}