<?php

namespace App\Machines;

use App\Models\Machine as Model;

class Machine
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function touch(array $data, $action)
    {
        $params = [
            'action'    => $action,
            'user_id'   => auth()->guard('api')->user()->id,
            'causer_id' => 1,
        ];

        $this->model->create();
    }
}