<?php

namespace App\Machines;

use App\Models\Machine;

class BaseMachine
{

    protected $user_id;

    public function __construct()
    {
        $this->user_id = auth()->check() ? auth()->guard('api')->user()->id : null;
    }

    public function fetch(array $params, $causer, $user_id = null)
    {
        $need = [
            'data'      => $params,
            'action'    => $this->action,
            'causer_id' => $causer,
            'user_id'   => $user_id ? : $this->user_id,
        ];

        Machine::create($need);
    }

    public function detch($causer)
    {
        $where = [
            'causer_id' => $causer,
            'user_id'   => $this->user_id,
            'action'    => $this->action,
        ];

        Machine::where($where)->delete();
    }
}