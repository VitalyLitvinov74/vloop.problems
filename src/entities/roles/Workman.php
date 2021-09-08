<?php


namespace vloop\problems\entities\problem\roles;


use vloop\problems\entities\abstractions\Role;

class Workman implements Role
{

    public function type(): string
    {
        return "workman";
    }
}