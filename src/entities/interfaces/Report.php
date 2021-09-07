<?php


namespace vloop\problems\entities\interfaces;


interface Report extends Entity
{
    public function attachToProblem(Problem $problem): Entity;
}