<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'id'            => $this->id,
            'avatar'        => $this->avatar,
            'name'          => $this->name,
            'email'         => $this->email,
            'is_active'     => $this->is_active,
            'website'       => $this->website,
            'gender'        => $this->gender,
            'describe'      => $this->describe,
            'resume'        => $this->resume,
            'wechat_qrcode' => $this->wechat_qrcode,
            'create_topics' => Topic::collection($this->creatorTopics()->orderBy('created_at', 'desc')->get()),
            'created_at'    => $this->created_at,
        ];
    }
}
