<?php

namespace App\Models;

use App\Models\Traits\Universal;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Universal;

    protected $guarded = [];

    public function getVoteCountAttribute($vote_count)
    {
        return (integer) $vote_count;
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reply()
    {
        return is_null($this->reply_id) ? false : $this->belongsTo(self::class);
    }
}
