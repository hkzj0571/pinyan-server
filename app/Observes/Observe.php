<?php

namespace App\Observes;

use App\Models\User;
use App\Models\Article;

class Observe
{
    public static function register()
    {
        User::observe(UserObserve::class);
        Article::observe(ArticleObserve::class);
    }
}
