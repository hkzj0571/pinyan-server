<?php

namespace App\Machines;

use App\Models\Article;
use App\Models\Comment;
use App\Http\Resources\CommentSimple;
use App\Http\Resources\ArticleSimple;

class VoteMachine extends BaseMachine
{
    public $action = 'vote';

    public function make(Comment $comment)
    {
        $params = [
            'comment_id' => $comment->id,
            'article_id' => $comment->article_id,
        ];

        $this->fetch($params, $comment->id);
    }

    public function generate(array $params)
    {
        $comment = auth()->guard('api')->user()->votes()->where('comment_id',$params['comment_id'])->first();

        $article = Article::find($params['article_id']);

        return [
            'comment' => new CommentSimple($comment),
            'article' => new ArticleSimple($article),
        ];
    }

    public function remove(Comment $comment)
    {
        $this->detch($comment->id);
    }
}
