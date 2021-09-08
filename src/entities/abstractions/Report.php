<?php


namespace vloop\problems\entities\abstractions;


interface Report extends Entity
{
    public function attachToProblem(Problem $problem): Entity;
}