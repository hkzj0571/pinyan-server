<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TopicSimple extends Resource
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
            'id'             => $this->id,
            'cover'          => $this->cover,
            'name'           => $this->name,
            'describe'       => $this->describe,
            'article_count'  => $this->article_count,
            'follower_count' => $this->follower_count,
            'created_at'     => $this->created_at,
            'focus_at'       => $this->when($this->pivot && @$this->pivot->created_at, function() {
                return hommization($this->pivot->created_at);
            }),
        ];
    }
}
