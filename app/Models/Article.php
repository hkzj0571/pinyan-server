<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Universal;

    protected $guarded = [];

    /**
     * 本地作用域，附加查询条件：模糊查询标题
     *
     * @param $query
     * @param bool $is_active
     * @return mixed
     */
    public function scopeLike($query, $keyword = '')
    {
        return $query->where('title', 'like', "%{$keyword}%");
    }

    /**
     * 访问器，获取纯文本简略
     *
     * @return string
     */
    public function getPureContentAttribute()
    {
        return mb_substr(strip_tags(str_replace("&nbsp;", '', htmlspecialchars_decode($this->content))), 0, 150, 'utf-8');
    }

    /**
     * 访问器，获取第一张图片作为封面图片
     *
     * @return mixed
     */
    public function getCoverAttribute()
    {
        preg_match("/<img\s[^>]*?src\s*=\s*([\'|\"])(.*?)\\1[^>]*\/?>/i",$this->content,$result);
        return @$result[2];
    }

    public function getReadCountAttribute()
    {
        return $this->read()->count();
    }

    public function getLikeCountAttribute()
    {
        return $this->users()->count();
    }

    /**
     * 此文章的发布用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 此文章所属的专题
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 喜欢此文章的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_like_articles')->withTimestamps();
    }

    /**
     * 此文章的评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 用户阅读文章的记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function read()
    {
        return $this->belongsToMany(User::class,'users_read_articles')->withTimestamps();
    }
}
