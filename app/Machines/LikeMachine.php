<?php

namespace App\Machines;

use App\Models\Article;
use App\Http\Resources\ArticleSimple;

class LikeMachine extends BaseMachine
{
    public $action = 'like';

    public function make(Article $article)
    {
        $params = [
            'article_id' => $article->id,
        ];

        $this->fetch($params, $article->id);
    }

    public function generate(array $params)
    {
        $article = auth()->guard('api')->user()->likes()->where('article_id',$params['article_id'])->first();

        return [
            'article' => new ArticleSimple($article),
        ];
    }

    public function remove(Article $article)
    {
        $this->detch($article->id);
    }
}
