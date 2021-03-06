<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersFollowUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_follow_users', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('follower_id')->references('id')->on('users')->onDelete('cascade')->comment('关注者ID');
            $table->integer('followed_id')->references('id')->on('users')->onDelete('cascade')->comment('被关注者ID');
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
        Schema::dropIfExists('users_follow_users');
    }
}
