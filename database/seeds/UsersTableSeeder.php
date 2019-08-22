<?php

use Illuminate\Database\Seeder;
use App\User;


use Faker\Factory as Faker;



class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create([
            'email' => 'vicajobs@gmail.com',
            'name' => 'Vic Datu Andam',
            'slug' => 'vic-datu-andam',
            'photo' => ''
        ]);

        factory(User::class, 5)->create();

//        $user = new User();
//        $user->name = 'Vic Datu Andam';
//        $user->slug = str_slug($user->name);
//        $user->about = "The found of this website, reason because I didn't see any website that offer positive life and mindset to the people.";
//        $user->email = 'mrjesuserwinsuarez@gmail.com';
//        $user->contact_email = 'mrjesuserwinsuarez@gmail.com';
//        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
//        $user->remember_token = str_random(10);
//        $user->save();
//
//
//        $user = new User();
//        $user->name = 'Mary Jean';
//        $user->slug = str_slug($user->name);
//        $user->about = "";
//        $user->email = 'mj@gmail.com';
//        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
//        $user->remember_token = str_random(10);
//        $user->save();
//
//
//
//        $user = new User();
//        $user->name = 'Well Mary';
//        $user->slug = str_slug($user->name);
//        $user->about = "";
//        $user->email = 'wellmary@gmail.com';
//        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
//        $user->remember_token = str_random(10);
//        $user->save();
//
//
//        $user = new User();
//        $user->name = 'Antiamer';
//        $user->slug = str_slug($user->name);
//        $user->about = "";
//        $user->email = 'antiamer@gmail.com';
//        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
//        $user->remember_token = str_random(10);
//        $user->save();
//
//
//
//        $user = new User();
//        $user->name = 'Ariel';
//        $user->slug = str_slug($user->name);
//        $user->about = "";
//        $user->email = 'ariel@gmail.com';
//        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
//        $user->remember_token = str_random(10);
//        $user->save();
//
//        $user = new User();
//        $user->name = 'Michael';
//        $user->slug = str_slug($user->name);
//        $user->about = "";
//        $user->email = 'michael@gmail.com';
//        $user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
//        $user->remember_token = str_random(10);
//        $user->save();
    }
}
