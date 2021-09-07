<?php


namespace vloop\problems\entities\problem\roles;


use vloop\problems\entities\interfaces\Role;

class Workman implements Role
{

    public function type(): string
    {
        return "workman";
    }
}