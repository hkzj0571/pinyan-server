<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait Universal
{
    public function hommization($date)
    {
        return Carbon::now() > Carbon::parse($date)->addDays(10)
            ? Carbon::parse($date)
            : Carbon::parse($date)->diffForHumans();
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