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
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
    $router->get('avatars', 'AvatarsController@index');
    $router->post('active', 'AuthController@active');

    $router->get('article/{article}', 'ArticlesController@show');

    $router->get('user/{user}', 'UsersController@look');

    Route::middleware('auth:api')->group(function($router) {
        $router->get('logout', 'AuthController@logout');
        $router->get('reset', 'AuthController@reset');
        $router->get('upload/token', 'UploadController@token');


        Route::prefix('user')->group(function($router) {
            $router->post('refresh', 'UsersController@refresh');
            $router->put('avatar', 'UsersController@avatar');
            $router->put('wechat_qrcode', 'UsersController@wechatQrCode');
            $router->delete('wechat_qrcode', 'UsersController@removeWechatQrCode');
            $router->put('basic', 'UsersController@basic');
            $router->put('profile', 'UsersController@profile');
            $router->post('articles', 'UsersController@articles');
        });

        Route::prefix('article')->group(function($router) {
            $router->post('select_topic', 'ArticlesController@selectTopics');
            $router->post('store', 'ArticlesController@store');
            $router->post('{article}/like', 'ArticlesController@like');
            $router->post('{article}/is_like','ArticlesController@isLike');
            $router->post('{article}/like_users','ArticlesController@likeUsers');
        });

        Route::prefix('comments')->group(function($router) {
            $router->post('store', 'CommentsController@store');
        });

    });

});
