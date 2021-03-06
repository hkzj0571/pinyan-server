<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ArticleComplex extends Resource
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
            'is_like'        => auth()->guard('api')->check() ? $this->users()->where('user_id', auth()->guard('api')->user()->id)->exists() : false,
            'topic'          => new TopicSimple($this->topic),
            'user'           => new UserSimple($this->user),
            'comments_count' => $this->comments->count(),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
