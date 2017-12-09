<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Universal;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 本地作用域，附加查询条件：用户名称
     *
     * @param $query
     * @param $name
     * @return mixed
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * 本地作用域，附加查询条件：是否被永久封禁
     *
     * @param $query
     * @param bool $is_nasty
     * @return mixed
     */
    public function scopeNasty($query, $is_nasty = false)
    {
        return $query->where('is_nasty', $is_nasty);
    }

    /**
     * 修改器，对密码进行 Hash 加密
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }


    /**
     * 关注该用户的人数
     *
     * @return int
     */
    public function getFollowerCountAttribute()
    {
        return $this->followers()->count();
    }

    /**
     * 账号激活时间
     *
     * @param $date
     * @return string|static
     */
    public function getActivedAtAttribute($date)
    {
        return $this->hommization($date);
    }

    /**
     * 该用户关注的人数
     *
     * @return int
     */
    public function getFollowedCountAttribute()
    {
        return $this->followeds()->count();
    }

    /**
     * @return int
     */
    public function getArticleCountAttribute()
    {
        return $this->articles()->count();
    }

    /**
     * 访问器，如果头像为空返回默认头像
     *
     * @param $avatar
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        return $avatar ? : 'http://p03uyojkp.bkt.clouddn.com/min-avatar.jpg';
    }

    /**
     * 修改器，保存用户名称时对名称进行首字母大写
     *
     * @param [type] $password
     * @return void
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords($name);
    }

    /**
     * 刷新激活 Token
     *
     * @return bool
     */
    public function resetActiveToken()
    {
        return $this->update(['active_token' => str_random(64)]);
    }

    /**
     * 用户发表的文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * 刷新找回密码Token
     *
     * @return bool
     */
    public function resetForgetToken()
    {
        return $this->update(['forget_token' => str_random(64)]);
    }

    /**
     * 用户关注的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followeds()
    {
        return $this->belongsToMany(self::class, 'users_follow_users', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * 关注用户的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'users_follow_users', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * 用户喜欢的文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(Article::class, 'users_like_articles')->withTimestamps();
    }

    /**
     * 用户发表的评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 用户关注的专题
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'users_focus_topics')->withTimestamps();
    }

    /**
     * 与用户相关的专题
     *
     * @return $this
     */
    public function manageTopics()
    {
        return $this->belongsToMany(Topic::class, 'users_manage_topics')->withTimestamps()->withPivot('is_creator');
    }

    /**
     * 用户是创建者的专题
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function creatorTopics()
    {
        return $this->belongsToMany(Topic::class, 'users_manage_topics')->withTimestamps()->wherePivot('is_creator', true);
    }

    /**
     * 用户是管理者的专题
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function manatorTopics()
    {
        return $this->belongsToMany(Topic::class, 'users_manage_topics')->withTimestamps()->wherePivot('is_creator', false);
    }

    /**
     * 用户阅读文章的记录
     */
    public function read()
    {
        return $this->belongsToMany(Article::class,'users_read_articles')->withTimestamps();
    }

    /**
     * 用户赞过的评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(Comment::class,'users_vote_comments')->withTimestamps();
    }


    /**
     * 用户的所有动态
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
