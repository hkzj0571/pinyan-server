<?php

namespace App\Machines;

use App\Models\User;
use App\Http\Resources\UserSimple;

class FollowMachine extends BaseMachine
{
    public $action = 'follow';

    public function make(User $user)
    {
        $params = [
            'user_id' => $user->id,
        ];

        $this->fetch($params, $user->id);
    }

    public function generate(array $params)
    {
        $article = auth()->guard('api')->user()->followeds()->where('followed_id',$params['user_id'])->first();

        return [
            'user' => new UserSimple($article),
        ];
    }

    public function remove(User $user)
    {
        $this->detch($user->id);
    }
}
