<?php


namespace vloop\problems\entities\problem\roles;


use vloop\problems\entities\abstractions\contracts\Role;

class Workman implements Role
{

    public function type(): string
    {
        return "workman";
    }
}