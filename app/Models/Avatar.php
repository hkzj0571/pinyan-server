<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $guarded = [];

    public function scopeNasty($query, $is_nasty = false)
    {
        return $query->where('is_nasty', $is_nasty);
    }
}
