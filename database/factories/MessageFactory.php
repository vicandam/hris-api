<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Message::class, function (Faker $faker) {


    $type = ['feedback', 'contact', 'comment', 'question'];

    return [
        'user_id' => User::inRandomOrder()->get()->first()->id,
        'recipient_id' => User::inRandomOrder()->get()->first()->id,
        'message' => $faker->paragraph,
        'subject' => $faker->title,
        'project_name' => $faker->catchPhrase,
        'email' =>  $faker->email,
        'skype_id' =>  $faker->userName,
        'name' => $faker->name,
        'type' => $type[rand(0, count($type)-1)]
    ];
});
