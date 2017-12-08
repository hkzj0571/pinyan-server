<?php

namespace App\Machines;

use App\Models\Article;

class NewArticleMachine extends Machine
{
    public function make(Article $article)
    {
        $params = [
            'article_id' => $article->id,
        ];

        $this->touch($params);
    }

    public function generate()
    {

    }

    public function remove()
    {

    }
}
