<?php

namespace App\Machines;


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

    public function generate()
    {

    }

    public function remove()
    {

    }
}
