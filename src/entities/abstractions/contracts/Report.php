<?php


namespace vloop\problems\entities\abstractions\contracts;


interface Report extends Entity
{
    public function attachToProblem(Problem $problem): Entity;
}