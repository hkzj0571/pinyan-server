<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TopicsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
    }
}
