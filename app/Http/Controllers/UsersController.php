<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSimple;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\TopicSimple;
use App\Http\Resources\UserComplex;
use App\Http\Resources\ArticleSimple;
use App\Exceptions\VerificationException;

class UsersController extends Controller
{

    /**
     * 更新头像
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(Request $request)
    {
        auth()->user()->update(
            $this->validate($request, rules('avatar'))
        );

        return succeed('头像已更新');
    }

    /**
     * 更新个人基本资料
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws VerificationException
     */
    public function basic(Request $request)
    {
        $needs = $this->validate($request, rules('basic'));

        if (
            $needs['name'] != auth()->user()->name
            && User::name($needs['name'])->exists()
        ) {
            throw new VerificationException('昵称已被使用，换一个吧');
        }

        auth()->user()->update($needs);

        return succeed('个人资料已更新');
    }

    /**
     * 更新微信二维码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wechatQrCode(Request $request)
    {
        auth()->user()->update(
            $this->validate($request, rules('wechat_qrcode'))
        );

        return succeed('微信二维码已更新');
    }

    /**
     * 删除微信二维码
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeWechatQrCode()
    {
        auth()->user()->update(['wechat_qrcode' => null]);

        return succeed('微信二维码已删除');
    }


    public function profile(Request $request)
    {
        auth()->user()->update(
            $this->validate($request, rules('profile'))
        );

        return succeed('个人资料已更新');
    }

    /**
     * 刷新用户资料
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return succeed(
            [
                'user' => new UserComplex(auth()->user()),
            ]
        );
    }

    /**
     * 显示用户个人主页
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return succeed(
            [
                'user' => new UserComplex($user),
            ]
        );
    }

    /**
     * 用户发表的文章
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function articles(Request $request)
    {
        $articles = auth()->user()->articles()->orderBy('created_at', 'desc')->paginate(10);
        return succeed(
            [
                'articles' => ArticleSimple::collection($articles),
            ]
        );
    }

    /**
     * 用户喜欢的文章
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeArticle(Request $request)
    {
        $articles = auth()->user()->likes()->orderBy('created_at', 'desc')->paginate(10);

        return succeed(
            [
                'articles' => ArticleSimple::collection($articles),
            ]
        );
    }

    /**
     * 用户关注的专题
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function focusTopics(Request $request)
    {
        $topics = auth()->user()->topics()->orderBy('created_at', 'desc')->paginate(10);

        return succeed(
            [
                'topics' => TopicSimple::collection($topics),
            ]
        );
    }

    /**
     * 用户关注的用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function followed(Request $request)
    {
        $followeds = UserSimple::collection(auth()->user()->followeds()->orderBy('created_at', 'desc')->paginate(10));

        return succeed(['followeds' => $followeds]);
    }

    /**
     * 关注用户的用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follower(Request $request)
    {
        $followers = UserSimple::collection(auth()->user()->followers()->orderBy('created_at', 'desc')->paginate(10));

        return succeed(['followers' => $followers]);
    }
}
