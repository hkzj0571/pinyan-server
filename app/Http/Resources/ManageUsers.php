<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ManageUsers extends Resource
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
            'is_creator' => $this->when($this->pivot,$this->pivot->is_creator),
        ];
    }
}
