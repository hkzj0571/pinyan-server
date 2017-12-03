<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserArticles extends Resource
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
            'cover'          => $this->cover,
            'content'        => $this->pure_content,
            'read_count'     => $this->read_count,
            'like_count'     => $this->like_count,
            'topic'          => new Topic($this->topic),
            'user'           => new User($this->user),
            'comments_count' => $this->comments()->count(),
            'created_at'     => $this->created_at,
        ];
    }
}
