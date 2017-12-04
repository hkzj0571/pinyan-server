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
     * 修改器，对密码进行 Hash 加密
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
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

    public function follows()
    {
        return $this->belongsToMany(self::class, 'users_follow_users', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany(Article::class, 'users_like_articles')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class,'users_focus_topics');
    }

    public function manageTopics()
    {
        return $this->belongsToMany(Topic::class,'users_manage_topics')->withTimestamps()->withPivot('is_creator');
    }

    public function creatorTopics()
    {
        return $this->belongsToMany(Topic::class,'users_manage_topics')->withTimestamps()->wherePivot('is_creator',true);
    }

    public function manatorTopics()
    {
        return $this->belongsToMany(Topic::class,'users_manage_topics')->withTimestamps()->wherePivot('is_creator',false);
    }
}
