<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use Universal;

    protected $guarded = [];

    public function setDataAttribute($data)
    {
        $this->attributes['data'] = json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getDataAttribute($data)
    {
        return json_decode($data, true);
    }

    /**
     * 动态所属的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
