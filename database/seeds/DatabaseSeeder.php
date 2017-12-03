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
        $this->call(AvatarsTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LikesTableSeeder::class);
    }
}
