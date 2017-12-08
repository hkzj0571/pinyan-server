<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MachineComplex extends Resource
{
    protected $medium = [
        'reply'   => \App\Machines\ReplyMachine::class,
        'comment' => \App\Machines\CommentMachine::class,
        'article' => \App\Machines\ArticleMachine::class,
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
