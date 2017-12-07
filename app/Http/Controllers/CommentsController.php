<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentSimple;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $needs = $this->validate($request, rules('comments.store'));

        $needs['user_id'] = auth()->user()->id;

        $comment = Comment::create($needs);

        return succeed(['comment' => new CommentSimple($comment)]);
    }

    public function vote(Request $request,Comment $comment)
    {
        $result = count($comment->votes()->toggle(auth()->user()->id)['attached']);

        $result ? $comment->increment('vote_count') : $comment->decrement('vote_count');

        return succeed(['type' => $result]);
    }
}
