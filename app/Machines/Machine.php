<?php

namespace App\Machines;

abstract class Machine
{
    public abstract function make(array $params);
}