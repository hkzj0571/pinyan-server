<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Universal;

    protected $guarded = [];

    /**
     * 访问器，获取赞数时强制转换为 Int 型
     *
     * @param $vote_count
     * @return int
     */
    public function getVoteCountAttribute($vote_count)
    {
        return (integer) $vote_count;
    }

    /**
     * 此评论所属的文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * 此评论所属的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 此评论是否是回复其他评论
     *
     * @return bool|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reply()
    {
        return is_null($this->reply_id) ? false : $this->belongsTo(self::class);
    }
}
