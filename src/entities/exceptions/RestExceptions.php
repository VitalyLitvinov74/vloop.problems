<?php


namespace vloop\problems\entities\exceptions;


use vloop\problems\entities\abstractions\contracts\Entities;
use vloop\problems\entities\abstractions\contracts\Entity;
use vloop\problems\entities\abstractions\contracts\Form;
use vloop\problems\entities\abstractions\EntitiesCollection;

class RestExceptions
{
    private $origin;

    public function __construct(Entities $origin) {
        $this->origin = $origin;
    }

    /**
     * @return array|Entities
     */
    public function collection(){
        try{
            return $this->origin;
        }catch (ValidateFieldsException $exception){
            return ['error'=>$exception->errors()];
        }
    }
}