<?php

namespace App\Machines;

abstract class Machine
{
    abstract public static function make(array $params);
}