<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Article extends Resource
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
            'title'          => $this->title,
            'content'        => $this->content,
            'read_count'     => $this->read_count,
            'like_count'     => $this->like_count,
            'topic'          => new Topic($this->topic),
            'user'           => new User($this->user),
            'comments'       => Comment::collection($this->comments()->orderBy('created_at', 'desc')->get()),
            'comments_count' => $this->comments->count(),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
