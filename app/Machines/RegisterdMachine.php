<?php

namespace App\Machines;

use App\Http\Resources\UserSimple;
use App\Models\User;

class RegisterdMachine extends BaseMachine
{
    public $action = 'registerd';

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
