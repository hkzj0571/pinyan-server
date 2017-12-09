<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MachineComplex extends Resource
{
    protected $medium = [
        'like'      => \App\Machines\LikeMachine::class,
        'vote'      => \App\Machines\VoteMachine::class,
        'reply'     => \App\Machines\ReplyMachine::class,
        'follow'    => \App\Machines\FollowMachine::class,
        'actived'   => \App\Machines\ActivedMachine::class,
        'comment'   => \App\Machines\CommentMachine::class,
        'article'   => \App\Machines\ArticleMachine::class,
        'registerd' => \App\Machines\RegisterdMachine::class,
    ];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(['action' => $this->action], app($this->medium[$this->action])->generate($this->data));
    }
}
