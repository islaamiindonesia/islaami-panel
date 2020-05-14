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
        $this->call(CategoriesTableSeeder::class);
        $this->call(VideoTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(ArticleSeeder::class);
    }
}
