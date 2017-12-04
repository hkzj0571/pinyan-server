<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserArticles;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
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

        if ($needs['name'] != auth()->user()->name
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
        return succeed(['user' => new UserResource(auth()->user())]);
    }

    public function look(User $user)
    {
        return succeed(['user' => new UserResource($user)]);
    }

    public function articles(Request $request)
    {
        return succeed(['articles' => UserArticles::collection(auth()->user()->articles()->orderBy('created_at','desc')->paginate(10))]);
    }

    public function focusArticle(Request $request)
    {
        return succeed(['articles' => UserArticles::collection(auth()->user()->likes()->orderBy('created_at','desc')->paginate(10))]);
    }
}
