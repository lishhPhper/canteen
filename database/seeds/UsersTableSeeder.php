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
        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            array (
                'id' => 1,
                'phone' => 18779174645,
                'password' => '$2y$10$0JSc3EXOtJDpU95ITaduqOuXkI9dtqx24PaEscMgxD9/1kkP6yfWO',
                'name' => '尼采',
                'avatar' => 'http://www.a.com/uploads/20190620/932b367cbadacc5047e597781b5f1727.jpg',
                'department' => '研发部',
                'type' => 1,
                'face_id' => '423654-454351dff-545',
                'remember_token' => NULL,
                'created_at' => '2019-06-05 09:24:26',
                'updated_at' => '2019-06-20 11:18:39',
            ),
            array (
                'id' => 2,
                'phone' => 17388700840,
                'password' => '$2y$10$0JSc3EXOtJDpU95ITaduqOuXkI9dtqx24PaEscMgxD9/1kkP6yfWO',
                'name' => '尼采--1',
                'avatar' => 'http://www.a.com/uploads/20190620/932b367cbadacc5047e597781b5f1727.jpg',
                'department' => '研发部',
                'type' => 2,
                'face_id' => 'dsf32-454351dff-545',
                'remember_token' => NULL,
                'created_at' => '2019-06-05 09:24:26',
                'updated_at' => '2019-06-20 11:18:39',
            ),
        ));
    }
}
