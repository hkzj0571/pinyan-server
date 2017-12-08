<?php

namespace App\Machines;

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

    public function generate()
    {

    }

    public function remove()
    {

    }
}
