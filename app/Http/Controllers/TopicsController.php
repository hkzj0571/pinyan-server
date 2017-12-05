<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeUsers;
use App\Http\Resources\TopicDetail;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserArticles;
use App\Http\Resources\Topic as TopicResource;

class TopicsController extends Controller
{
    public function newArticles(Request $request, Topic $topic)
    {
        return succeed(['articles' => UserArticles::collection($topic->articles()->orderBy('created_at', 'desc')->paginate(10))]);
    }

    public function hotArticles(Request $request, Topic $topic)
    {
        return succeed(['articles' => UserArticles::collection($topic->articles()->orderBy('read_count', 'desc')->paginate(10))]);
    }

    public function isFocus(Request $request, Topic $topic)
    {
        return succeed(['is_focus' => $topic->users()->where('user_id', auth()->user()->id)->exists()]);
    }

    public function focus(Request $request, Topic $topic)
    {
        $toggled = $topic->users()->toggle(auth()->user()->id);

        $toggled['attached']
            ? $topic->increment('follower_count')
            : $topic->decrement('follower_count');

        return succeed(['type' => $toggled['attached'] ? 'attached' : 'detached']);
    }

    public function topic(Request $request, Topic $topic)
    {
        return succeed(['topic' => new TopicDetail($topic)]);
    }

    public function store(Request $request)
    {
        $needs = $this->validate($request, rules('topics.store'));

        $topic = Topic::create(array_except($needs, 'manages'));

        $topic->manageUsers()->attach(auth()->user()->id, ['is_creator' => true]);

        $topic->manageUsers()->attach($needs['manages']);

        return succeed(['topic' => new TopicResource($topic)]);
    }

    public function update(Request $request, Topic $topic)
    {
        $creator = $topic->creatorUser()->first();

        if ($creator->id !== auth()->user()->id) {
            return failed('你没有权限修改此话题');
        }

        $needs = $this->validate($request, rules('topics.update'));

        if ($needs['name'] != $topic->name && Topic::where('name', $needs['name'])->exists()) {
            return failed('专题名已存在');
        }

        $topic->update(array_except($needs, 'manages'));

        $topic->manageUsers()->detach();

        $topic->manageUsers()->attach(auth()->user()->id, ['is_creator' => true]);

        $topic->manageUsers()->attach($needs['manages']);

        return succeed('专题已更新');
    }

    public function users(Request $request)
    {
        return succeed([
           'users' => request()->query('query')
               ? LikeUsers::collection(
                   User::active()->like(request()->query('query'))->where('id','!=',auth()->user()->id)->limit(10)->get()
               )
               : [],
       ]);
    }

    public function usersIn(Request $request)
    {
        return $request->all();
    }
}
