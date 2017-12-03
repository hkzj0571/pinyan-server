<?php

use Illuminate\Database\Seeder;

class AvatarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls = [
            'http://p03uyojkp.bkt.clouddn.com/17469429.jpeg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/timg%20%283%29.jpeg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/timg.jpeg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/timg%20%282%29.jpeg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-9d8060d68104c40d93ada1be02c17f73_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-1a7fb75bdc0de880cfbe7277ff49b0be_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/timg%20%281%29.jpeg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-10f1682b99367fe115ac0639db8ac5d6_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-2d1d9afe4bfe6395351f134f3182719f_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-3f14ea608cc17bad296a9d553d738ae6_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-9a67d1e5793f8cd8a96468f24c8f53aa_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-4ac687605d4ec58e6bf056f2bb5d0dbb_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-53bf9b0ef5980b2cce5b390a38393270_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-72b0ffed21f5292360aaca69ef103be2_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-79e42ed4fd2025b57f6f07562d1d484c_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-80b8b5b7bac7d9eaa654bc9719902c13_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-894ab6ddfac5e5712dc56caa5a9fab36_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-89e46c3b044eac2727413e521da80452_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-3183e0661153df5e77d5c258d87d7cb1_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-7327a2e0f87cd0952d03c8734f1ce8ca_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-7193bf66642831f8ef7e364c62e36907_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-752576508c2919a14df70bd1f9a0e220_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-2432c6b242988e6b9ba60e7d14845522_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-399f37d563959af626fc4c1bc94ffc0f_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-b642f5bacbba1c184b9912a45be45d4d_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-a728cd5fa0e2d1bb7c28d118909b3f06_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-a19e8c634aff087f1eb2c60e05b92c15_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-b5dc79c6ac6ced7abeeca8d3f5637585_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-cc7cee2d04313052d85573520847523d_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-db46a6702ee7c89a5995a70c8a46d14d_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-f80e392090309f497b30c90facad6e59_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
            'http://p03uyojkp.bkt.clouddn.com/v2-f5a8bff97612ae88ba6c159100fcbb01_hd.jpg?imageView2/1/w/100/h/100/q/75|imageslim',
        ];

        $data = [];

        foreach ($urls as $url) {
            $data[] = ['url' => $url];
        }

        DB::table('avatars')->insert($data);
    }
}
