<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait Universal
{
    /**
     * 本地作用域，附加查询条件：是否激活
     *
     * @param $query
     * @param bool $is_active
     * @return mixed
     */
    public function scopeActive($query, $is_active = true)
    {
        return $query->where('is_active', $is_active);
    }

    /**
     * 本地作用域，附加查询条件：模糊查询名称
     *
     * @param $query
     * @param bool $is_active
     * @return mixed
     */
    public function scopeLike($query, $keyword = '')
    {
        return $query->where('name', 'like', "%{$keyword}%");
    }

    public function hommization($date)
    {
        if (Carbon::now() > Carbon::parse($date)->addDays(30)) {
            return Carbon::parse($date)->toDateTimeString();
        }
        return Carbon::parse($date)->diffForHumans();
    }

    public function getCreatedAtAttribute($date)
    {
        return $this->hommization($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return $this->hommization($date);
    }
}