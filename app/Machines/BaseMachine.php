<?php

namespace App\Machines;

use App\Models\Machine;

class BaseMachine
{

    protected $user_id;

    public function __construct()
    {
        $this->user_id = auth()->guard('api')->user()->id;
    }

    public function fetch(array $params, $causer)
    {
        $need = [
            'data'      => $params,
            'action'    => $this->action,
            'causer_id' => $causer,
            'user_id'   => $this->user_id,
        ];

        Machine::create($need);
    }
}