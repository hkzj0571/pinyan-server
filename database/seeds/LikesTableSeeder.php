<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = \App\Models\Article::all();

        $users = \App\Models\User::pluck('id')->toArray();

        foreach ($articles as $article) {
            $article->likes()->attach($users);
        }
    }
}
