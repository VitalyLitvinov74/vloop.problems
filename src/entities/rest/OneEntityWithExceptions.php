<?php


namespace vloop\problems\entities\rest;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\contracts\VloopException;
use vloop\problems\entities\errors\ArrayErrorsAsEntity;
use vloop\problems\entities\exceptions\NotSavedRecord;
use vloop\problems\entities\exceptions\NotValidatedFields;

class OneEntityWithExceptions implements Entity
{
    private $origin;

    public function __construct(Entity $origin) {
        $this->origin = $origin;
    }

    public function id(): int
    {
        return $this->origin->id();
    }

    public function printYourself(): array
    {
        return $this->origin->printYourself();
    }

    /**
     * @param Form $form
     * @return Entity
     */
    public function changeLineData(Form $form): Entity
    {
        try{
           return $this->origin->changeLineData($form);
        }
        catch (NotSavedRecord $exception){
            return $this->restError($exception);
        }
        catch (NotValidatedFields $exception){
            return $this->restError($exception);
        }
    }

    private function restError(VloopException $exception){
        return new RestError(
            new ArrayErrorsAsEntity(
                $exception->errors()
            )
        );
    }

    public function remove(): void
    {
        $this->origin->remove();
    }
}