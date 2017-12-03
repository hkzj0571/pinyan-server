<?php

use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            '摄影', '文学', '健身', '诗歌',
            '手绘', '旅行·在路上', '社会热点',
            '简书电影', '历史', '读书',
            '上班这点事儿', '程序员',
        ];

        $covers = [
            '//upload.jianshu.io/collections/images/16/computer_guy.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/256739/461792731394569594.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/28/%E4%B8%8A%E7%8F%AD%E8%BF%99%E7%82%B9%E4%BA%8B%E5%84%BF.jpeg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/25920/enhanced-buzz-wide-16461-1372163238-8.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/75/22.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/261938/man-hands-reading-boy-large.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/30/IMG_2226.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/56/Mypsd_176980_201208311721380003B.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/264569/2.pic.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/21/20120316041115481.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180',
            '//upload.jianshu.io/collections/images/4/sy_20091020135145113016.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/180/h/180'
        ];

        $data = [];

        for ($i = 0;$i<100;$i++) {
            $data[] = [
                'cover' => array_random($covers),
                'name' => array_random($name),
                'describe' => '专题描述',
                'is_active' => true,
            ];
        }

        DB::table('topics')->insert($data);
    }
}
