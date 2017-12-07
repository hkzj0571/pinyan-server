<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\UserSimple;
use App\Http\Resources\TopicSimple;
use App\Http\Resources\ArticleSimple;
use App\Http\Resources\ArticleComplex;

class ArticlesController extends Controller
{

    /**
     * 拉取专题数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function topics(Request $request)
    {
        $topics = TopicSimple::collection(
            Topic::active()->like(request('query'))->limit(10)->get()
        );

        return succeed(['topics' => $topics]);
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

        $article = Article::create($needs);

        return succeed(['article' => new ArticleSimple($article)]);
    }

    /**
     * 显示文章
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Article $article)
    {
        app(\App\Cache\Articles\Read::class)->make($article);
        return succeed(['article' => new ArticleComplex($article)]);
    }

    /**
     * @param Request $request
     */
    public function like(Request $request, Article $article)
    {
        $toggled = (boolean) count($article->likes()->toggle(auth()->user()->id)['attached']);

        return succeed(['type' => $toggled]);
    }

    /**
     * 获取喜欢此文章的用户
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeUsers(Request $request, Article $article)
    {
        $users = UserSimple::collection($article->users()->orderBy('created_at', 'desc')->paginate(10));

        return succeed(['users' => $users]);
    }

    /**
     * 更新文章
     *
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Article $article)
    {
        $needs = $this->validate($request, rules('article.update'));

        $article->update($needs);

        return succeed('文章更新成功');
    }
}
