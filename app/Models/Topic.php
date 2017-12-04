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

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_focus_topics');
    }

    public function manageUsers()
    {
        return $this->belongsToMany(User::class,'users_manage_topics')->withTimestamps()->withPivot('is_creator');
    }

    public function creatorUser()
    {
        return $this->belongsToMany(User::class,'users_manage_topics')->withTimestamps()->wherePivot('is_creator',true);
    }
}
