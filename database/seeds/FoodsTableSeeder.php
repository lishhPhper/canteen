<?php

use Illuminate\Database\Seeder;

class FoodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('foods')->delete();
        
        \DB::table('foods')->insert(array (
            0 => 
            array (
                'id' => 3,
                'name' => '鱼香肉丝',
                'num' => 2223,
                'img_url' => 'images/72b4a2b758780352d27aac81f10b5b87.jpg',
                'created_at' => '2019-08-19 09:37:24',
                'updated_at' => '2019-08-19 10:09:26',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => '鱼香肉丝2',
                'num' => 2222,
                'img_url' => 'images/72b4a2b758780352d27aac81f10b5b87.jpg',
                'created_at' => '2019-08-19 09:37:24',
                'updated_at' => '2019-08-19 09:37:24',
            ),
        ));
        
        
    }
}