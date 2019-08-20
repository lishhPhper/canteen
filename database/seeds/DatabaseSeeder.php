<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(FoodsTableSeeder::class);
        $this->call(ServerFoodsTableSeeder::class);
    }
}
