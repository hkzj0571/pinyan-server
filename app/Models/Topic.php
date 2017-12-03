<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Universal;

    protected $guarded = [];

    public function scopeActive($query, $is_active = true)
    {
        return $query->where('is_active', $is_active);
    }

    public function scopeLike($query, $keyword = '')
    {
        return $query->where('name', 'like', "%{$keyword}%");
    }
}
