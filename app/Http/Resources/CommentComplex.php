<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommentComplex extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'content'    => $this->content,
            'user'       => new UserSimple($this->user),
            'vote_count' => $this->vote_count,
            'reply'      => $this->reply,
            'childers'   => CommentSimple::collection($this->childers),
            'created_at' => $this->created_at,
        ];
    }
}
