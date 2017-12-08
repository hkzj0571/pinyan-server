<?php

namespace App\Machines;

abstract class Machine
{
    abstract public function make(array $params);
}