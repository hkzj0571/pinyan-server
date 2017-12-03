<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Universal;

    protected $guarded = [];

    public function scopeActive($query, $is_active = true)
    {
        $this->decrement();
        return $query->where('is_active', $is_active);
    }

    public function scopeLike($query, $keyword = '')
    {
        return $query->where('title', 'like', "%{$keyword}%");
    }

    public function getPureContentAttribute($value)
    {
        return mb_substr(strip_tags(str_replace("&nbsp;", '', htmlspecialchars_decode($this->content))), 0, 100, 'utf-8');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
