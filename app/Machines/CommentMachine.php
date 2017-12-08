<?php

namespace App\Machines;


use App\Http\Resources\ArticleSimple;
use App\Http\Resources\CommentSimple;
use App\Models\Article;
use App\Models\Comment;

class CommentMachine extends BaseMachine
{
    public $action = 'comment';

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
        $comment = Comment::find($params['comment_id']);

        $article = Article::find($params['article_id']);

        return [
            'comment' => new CommentSimple($comment),
            'article' => new ArticleSimple($article),
        ];
    }

    public function remove()
    {

    }
}
