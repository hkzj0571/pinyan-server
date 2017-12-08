<?php

namespace App\Observes;


use App\Models\Comment;

class CommentObserve
{
    public function created(Comment $comment)
    {
        app(
            is_null($comment->reply_id)
                ? \App\Machines\CommentMachine::class
                : \App\Machines\ReplyMachine::class
        )->make($comment);
    }
}