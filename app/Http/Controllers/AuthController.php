<?php

namespace App\Http\Controllers;

use App\Events\UserRegisterd;
use App\Exceptions\UnauthorizedException;
use App\Http\Resources\UserComplex;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ProxyHelpers;

class AuthController extends Controller
{
    use ProxyHelpers;

    /**
     * 用户登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedException
     */
    public function login(Request $request)
    {
        $needs = $this->validate($request, rules('login'));

        $user = User::where('email', $needs['email'])->first();

        if (!$user) {
            throw new UnauthorizedException('此用户不存在');
        }

        if ($user->is_nasty) {
            throw new UnauthorizedException('此账号已被永久封禁');
        }

        $tokens = $this->authenticate();

        return succeed(['token' => $tokens, 'user' => new UserComplex($user)]);
    }

    /**
     * 用户注册
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $needs = $this->validate($request, rules('register'));

        $user = User::create($needs);

        event(new UserRegisterd($user));

        $tokens = $this->authenticate();

        app(\App\Machines\RegisterdMachine::class)->make($user);

        return succeed(['token' => $tokens, 'user' => new UserComplex($user)]);
    }

    /**
     * 用户退出
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->user()->token()->delete();
        return succeed('你已经安全退出');
    }

    /**
     * 重新发送激活邮件
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        if (!auth()->user()->is_active && time() - cache('send_active_mail', 0) > 10) {
            app(\App\Mailers\ActiveMailer::class)->send(auth()->user());
            cache()->put('send_active_mail', time());
            return succeed('邮件已重新发送');
        }

        return failed('邮件发送失败，账号已激活或间隔时间太短');
    }

    /**
     * 激活用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Request $request)
    {
        $user = User::active(false)->where('active_token', request('token'))->first();

        if ($user && $user->update(['is_active' => true]) && $user->resetActiveToken()) {
            $user->update(['actived_at' => Carbon::now()]);
            app(\App\Machines\ActivedMachine::class)->make($user);
            return succeed('邮箱已验证成功');
        } else {
            return failed('验证邮箱失败，账号状态异常或 Token 错误');
        }
    }
}
