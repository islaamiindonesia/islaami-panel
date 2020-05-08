<?php

use App\Admin;
use App\Role;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::where('name', 'super admin')->first();
        $islaami = Role::where('name', 'islaami')->first();
        $playmi = Role::where('name', 'playmi')->first();

        $user = new Admin();
        $user->name = "Super Admin";
        $user->email = "superadmin@mail.com";
        $user->password = Hash::make("password");
        $user->is_super = true;
        $user->save();
        $user->roles()->sync([$superAdmin->id]);

        $user = new Admin();
        $user->name = "Admin Islaami";
        $user->email = "islaami@mail.com";
        $user->password = Hash::make("password");
        $user->save();
        $user->roles()->attach($islaami);

        $user = new Admin();
        $user->name = "Admin Playmi";
        $user->email = "playmi@mail.com";
        $user->password = Hash::make("password");
        $user->save();
        $user->roles()->attach($playmi);
    }
}
