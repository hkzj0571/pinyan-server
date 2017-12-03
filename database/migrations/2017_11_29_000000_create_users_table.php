<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->comment('头像');
            $table->string('name')->unique()->comment('名称');
            $table->string('email')->unique()->comment('Email');
            $table->string('password')->comment('密码');
            $table->string('active_token')->comment('激活Token');
            $table->string('forget_token')->comment('找回密码Token');
            $table->string('website')->nullable()->comment('个人站点');
            $table->string('gender')->nullable()->comment('性别');
            $table->string('describe')->nullable()->comment('一句话描述');
            $table->text('resume')->nullable()->comment('个人简介');
            $table->string('wechat_qrcode')->nullable()->comment('微信二维码');
            $table->boolean('is_active')->default(false)->comment('是否激活');
            $table->boolean('is_nasty')->default(false)->comment('是否被拉入黑名单');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
