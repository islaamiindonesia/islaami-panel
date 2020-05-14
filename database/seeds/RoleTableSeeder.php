<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "super admin";
        $role->description = "super admin";
        $role->save();

        $role = new Role();
        $role->name = "islaami";
        $role->description = "admin islaami";
        $role->save();

        $role = new Role();
        $role->name = "playmi";
        $role->description = "admin playmi";
        $role->save();
    }
}
