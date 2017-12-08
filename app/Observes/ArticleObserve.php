<?php

namespace App\Observes;

use App\Models\Article;

class ArticleObserve
{
    public function created(Article $article)
    {
        app(\App\Machines\ArticleMachine::class)->make($article);
    }
}