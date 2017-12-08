<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserSimple extends Resource
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
            'id'               => $this->id,
            'avatar'           => $this->avatar,
            'name'             => $this->name,
            'gender'           => $this->gender,
            'follower_count'   => $this->follower_count,
            'followed_count'   => $this->followed_count,
            'article_count'    => $this->article_count,
            'gender'           => $this->gender,
            'resume'           => $this->resume,
            'describe'         => $this->describe,
            'pivot_created_at' => $this->when($this->pivot && @$this->pivot->created_at, function() {
                return hommization($this->pivot->created_at);
            }),
            'is_creator'       => $this->when($this->pivot, @$this->pivot->is_creator),
            'is_follow'        => auth()->guard('api')->check() ? auth()->guard('api')->user()->followeds()->where('followed_id', $this->id)->exists() : false,
            'created_at'       => $this->created_at,
        ];
    }
}
