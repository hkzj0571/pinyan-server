<?php

namespace App\Observes;

use App\Models\User;

class Observe
{
    public static function register()
    {
        User::observe(UserObserve::class);
    }
}