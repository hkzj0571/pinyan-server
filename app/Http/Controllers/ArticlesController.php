<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeUsers;
use App\Http\Resources\UserArticles;
use App\Models\Topic;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Topic as TopicResource;
use App\Http\Resources\Article as ArticleResource;


class ArticlesController extends Controller
{

    /**
     * 拉取专题数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectTopics(Request $request)
    {
        return succeed([
           'topics' => request('query')
               ? TopicResource::collection(
                   Topic::active()->like(request('query'))->limit(10)->get()
               )
               : [],
       ]);
    }

    /**
     * 新增文章
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $needs = $this->validate($request, rules('article.store'));

        $needs['user_id'] = auth()->user()->id;

        Article::create($needs);

        return succeed('文章发布成功');
    }

    public function show(Request $request, Article $article)
    {
        $article->increment('read_count');
        return succeed(['article' => new ArticleResource($article)]);
    }

    /**
     * @param Request $request
     */
    public function like(Request $request, Article $article)
    {
        $toggled = $article->likes()->toggle(auth()->user()->id);

        $toggled['attached']
            ? $article->increment('like_count')
            : $article->decrement('like_count');

        return succeed(['type' => $toggled['attached'] ? 'attached' : 'detached']);
    }

    public function isLike(Request $request, Article $article)
    {
        return succeed(['is_like' => $article->likes()->where('user_id', auth()->user()->id)->exists()]);
    }

    public function likeUsers(Request $request,Article $article)
    {
        return succeed(['users' => LikeUsers::collection($article->likes()->orderBy('created_at','desc')->paginate(10))]);
    }

    public function update(Request $request,Article $article)
    {
        $needs = $this->validate($request, rules('article.update'));

        $article->update($needs);

        return succeed('文章更新成功');
    }
}
