<?php


namespace vloop\problems\entities\problem;


use vloop\entities\contracts\Entities;
use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;
use vloop\entities\exceptions\NotSavedData;
use vloop\problems\tables\TableProblems;

abstract class AbstractProblems implements Entities
{
    /**
     * @param Form $form
     * @return Entity
     * @throws NotSavedData
     * @throws \vloop\entities\exceptions\NotValidatedFields
     */
    public function add(Form $form): Entity
    {
        $fields = $form->validatedFields();
        $record = new TableProblems($fields);
        if($record->save()){
            return new ProblemSQL($record->id);
        }
        throw new NotSavedData($record->getErrors(),422);
    }
}