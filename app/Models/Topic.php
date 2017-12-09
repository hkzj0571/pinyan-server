<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Universal;

    protected $guarded = [];

    /**
     * 访问器，查询出专题文章数
     *
     * @return int
     */
    public function getArticleCountAttribute()
    {
        return $this->articles()->count();
    }

    /**
     * 访问器，查询出专题关注人数
     *
     * @return int
     */
    public function getFollowerCountAttribute()
    {
        return $this->users()->count();
    }

    /**
     * 访问器，对 describe 属性进行换行操作
     *
     * @param $describe
     * @return string
     */
    public function getDescribeAttribute($describe)
    {
        return nl2br($describe);
    }

    /**
     * 属于此专题的文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * 关注了此专题的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_focus_topics')->withTimestamps();
    }

    /**
     * 此专题的管理用户与创建者
     *
     * @return $this
     */
    public function manageUsers()
    {
        return $this->belongsToMany(User::class,'users_manage_topics')->withTimestamps()->withPivot('is_creator');
    }

    /**
     * 此专题的创建者
     *
     * @return $this
     */
    public function creatorUser()
    {
        return $this->belongsToMany(User::class,'users_manage_topics')->withTimestamps()->wherePivot('is_creator',true);
    }
}
