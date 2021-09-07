<?php


namespace vloop\problems\entities\problem\roles;


use vloop\problems\entities\interfaces\Role;

class Foreman implements Role
{

    public function type(): string
    {
        return 'foreman';
    }
}