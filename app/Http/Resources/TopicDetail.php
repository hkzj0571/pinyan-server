<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TopicDetail extends Resource
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
            'creator'        => new User($this->creatorUser()->first()),
            'manages'        => ManageUsers::collection($this->manageUsers()->orderBy('created_at', 'desc')->get()),
            'created_at'     => $this->created_at,
        ];
    }
}
