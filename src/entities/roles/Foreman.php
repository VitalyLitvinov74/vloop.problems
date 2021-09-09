<?php


namespace vloop\problems\entities\problem\roles;


use vloop\problems\entities\abstractions\contracts\Role;

class Foreman implements Role
{

    public function type(): string
    {
        return 'foreman';
    }
}