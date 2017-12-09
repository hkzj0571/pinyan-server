<?php

namespace App\Machines;

use App\Models\User;
use App\Http\Resources\UserSimple;

class ActivedMachine extends BaseMachine
{
    public $action = 'actived';

    public function make(User $user)
    {
        $this->fetch([], 0, $user->id);
    }

    public function generate()
    {
        return [
            'user' => new UserSimple(auth()->guard('api')->user()),
        ];
    }

    public function remove()
    {

    }
}
