<?php


namespace vloop\problems\entities\problem;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\tables\TableProblems;

abstract class AbstractProblems implements Entities
{
    public function add(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = new TableProblems($fields);
        if($record->save()){
            return new ProblemSQL($record->id);
        }
        throw new NotSavedRecord($record->getErrors(),422);
    }
}