<?php

namespace App\Cache\Articles;

use Cache;
use App\Models\Article;
use Carbon\Carbon;

class Read
{
    protected $key = 'article_read';

    public function make(Article $article)
    {
        Cache::forever($this->key, $this->from($article));
    }

    public function from(Article $article)
    {
        $reads = Cache::get($this->key, []);

        array_push($reads,[
            'user_id'    => (int) @auth()->user()->id,
            'article_id' => $article->id,
            'read_at'    => Carbon::now(),
        ]);

        return $reads;
    }
}