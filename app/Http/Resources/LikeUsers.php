<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LikeUsers extends Resource
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
            'avatar'     => $this->avatar,
            'name'       => $this->name,
            'gender'     => $this->gender,
            'created_at' => $this->when($this->pivot,function(){
                return hommization($this->pivot->created_at);
            }),
        ];
    }
}
