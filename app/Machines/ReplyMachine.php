<?php

namespace App\Machines;

use App\Http\Resources\ArticleSimple;
use App\Http\Resources\CommentSimple;
use App\Models\Article;
use App\Models\Comment;

class ReplyMachine extends BaseMachine
{
    public $action = 'reply';

    public function make(Comment $comment)
    {
        $params = [
            'comment_id' => $comment->id,
            'reply_id'   => $comment->reply_id,
            'article_id' => $comment->article_id,
        ];

        $this->fetch($params, $comment->id);
    }

    public function generate(array $params)
    {
        $comment = Comment::find($params['comment_id']);

        $article = Article::find($params['article_id']);

        $reply = Comment::find($params['reply_id']);


        return [
            'comment' => new CommentSimple($comment),
            'article' => new ArticleSimple($article),
            'reply'   => new CommentSimple($reply),
        ];
    }

    public function remove()
    {

    }
}
