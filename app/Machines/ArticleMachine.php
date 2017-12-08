<?php

namespace App\Machines;

use App\Models\Article;

class ArticleMachine extends BaseMachine
{
    public $action = 'article';

    public function make(Article $article)
    {
        $params = [
            'article_id' => $article->id,
        ];

        $this->fetch($params, $article->id);
    }

    public function generate()
    {

    }

    public function remove()
    {

    }
}
