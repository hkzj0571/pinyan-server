<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix(api_version())->group(function($router) {

    /* 登陆 */
    $router->post('login', 'AuthController@login');

    /* 注册 */
    $router->post('register', 'AuthController@register');

    /* 用户激活 */
    $router->post('active', 'AuthController@active');

    /* 展示文章 */
    $router->get('article/{article}', 'ArticlesController@show')->where('article', '[0-9]+');

    /* 展示用户 */
    $router->get('user/{user}', 'UsersController@show')->where('user', '[0-9]+');

    /* 以下路由需要携带经过Passport Token 才可以访问 */
    Route::middleware('auth:api')->group(function($router) {

        /* 退出 */
        $router->get('logout', 'AuthController@logout');

        /* 重新发送验证邮件 */
        $router->get('reset', 'AuthController@reset');

        /* 获取上传文件的 Token */
        $router->get('upload/token', 'UploadController@token');


        Route::prefix('user')->group(function($router) {
            /* 拉取信息 */
            $router->post('refresh', 'UsersController@refresh');
            /* 更新头像 */
            $router->put('avatar', 'UsersController@avatar');
            /* 更新微信二维码 */
            $router->put('wechat_qrcode', 'UsersController@wechatQrCode');
            /* 删除微信二维码 */
            $router->delete('wechat_qrcode', 'UsersController@removeWechatQrCode');
            /* 更新基本资料 */
            $router->put('basic', 'UsersController@basic');
            /* 更新个人资料 */
            $router->put('profile', 'UsersController@profile');
            /* 发表文章 */
            $router->post('articles', 'UsersController@articles');
            /* 喜欢的文章 */
            $router->get('like_article', 'UsersController@likeArticle');
            /* 关注的专题 */
            $router->get('focus_topics', 'UsersController@focusTopics');
            /** 我关注的人 */
            $router->get('followed','UsersController@followed');
            /** 关注我的人 */
            $router->get('follower','UsersController@follower');
            /** 关注用户 */
            $router->post('follow','UsersController@follow');
        });

        Route::prefix('article')->group(function($router) {
            /* 拉取新增文章时的专题 */
            $router->get('topic', 'ArticlesController@topics');
            /* 新增文章 */
            $router->post('store', 'ArticlesController@store');
            /* 更新文章 */
            $router->put('{article}', 'ArticlesController@update');
            /* 喜欢这篇文章 */
            $router->post('{article}/like', 'ArticlesController@like');
            /* 拉取喜欢这篇文章的用户 */
            $router->post('{article}/users', 'ArticlesController@users');
            /** 拉取这篇文章的评论 */
            $router->post('{article}/comments', 'ArticlesController@comments');
        });

        Route::prefix('comments')->group(function($router) {
            /* 新增评论 */
            $router->post('store', 'CommentsController@store');
            /** 点赞或者取消评论 */
            $router->post('{comment}/vote','CommentsController@vote');
        });

        Route::prefix('topics')->group(function($router) {
            /* 新增专题 */
            $router->post('store', 'TopicsController@store');
            $router->post('users_in', 'TopicsController@usersIn');
            $router->post('{topic}/new_articles', 'TopicsController@newArticles');
            $router->post('{topic}/hot_articles', 'TopicsController@hotArticles');
            $router->post('{topic}/is_focus', 'TopicsController@isFocus');
            $router->post('{topic}/focus', 'TopicsController@focus');
            $router->post('{topic}', 'TopicsController@topic');
            $router->put('{topic}', 'TopicsController@update');
            $router->get('users', 'TopicsController@users');
        });

        Route::prefix('machines')->group(function($router){
            $router->get('/','MachinesController@index');
        });

    });

});
