<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 0; $i < 200; $i ++) {
            $data[] = [
                'avatar' => rand_avatar(),
                'name' => $i.array_random(['Seaony','青栀','半路友人i','岛是没有潮的心','柠檬草的味道、','理想中的自己','拂过衣襟','过期关系','用旅行来遗忘爱']),
                'email' => $i.'seaony@outlook.com',
                'password' => bcrypt('password'),
                'active_token' => str_random(64),
                'forget_token' => str_random(64),
            ];
        }

        DB::table('users')->insert($data);
    }
}
