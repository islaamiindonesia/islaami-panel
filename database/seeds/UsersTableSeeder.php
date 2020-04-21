<?php

use App\Playlist;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->fullname = "John Doe";
        $user->gender = "L";
        $user->email = "youdant@gmail.com";
        $dateOfBirth = Carbon::createFromFormat('Y-m-d', '1996-03-29');
        $user->birthdate = $dateOfBirth->format('d-m-Y');
        $user->password = Hash::make("password");
        $user->save();

        $user->followChannels()->attach(1);
//        $user->blacklistChannels()->attach(1);
        $user->videoView()->attach(1);

        /*DB::table('blacklists')->insert([
            'user_id' => 1,
            'channel_id' => 1
        ]);*/

        $playlist = new Playlist();
        $playlist->name = "Uno";
        $playlist->user_id = 1;
        $playlist->save();
        $playlist->videos()->attach(1);

        $playlist = new Playlist();
        $playlist->name = "Dos";
        $playlist->user_id = 1;
        $playlist->save();

        $user->videos()->attach(1);
    }
}
