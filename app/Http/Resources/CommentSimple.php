<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommentSimple extends Resource
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
            'is_vote'    => auth()->guard('api')->check() ? auth()->guard('api')->user()->votes()->where('comment_id', $this->id)->exists() : false,
            'created_at' => $this->created_at,
            'vote_at'    => $this->when($this->pivot && @$this->pivot->created_at, function() {
                return hommization($this->pivot->created_at);
            }),
        ];
    }
}
