<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TopicComplex extends Resource
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
            'creator'        => new UserSimple($this->creatorUser()->first()),
            'manages'        => UserSimple::collection($this->manageUsers()->orderBy('created_at', 'desc')->get()),
            'created_at'     => $this->created_at,
            'is_focus'       => auth()->guard('api')->check() ? auth()->guard('api')->user()->topics()->where('topic_id',$this->id)->exists() : false,
        ];
    }
}
