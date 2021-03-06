<?php

namespace App\Observes;

use App\Models\User;

class UserObserve
{
    public function creating(User $user)
    {
        $user->fill([
            'active_token' => str_random(64),
            'forget_token' => str_random(64),
        ]);
    }
}