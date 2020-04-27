<?php

use Faker\Generator as Faker;
use App\User;
use App\Post;

$factory->define(App\Interaction::class, function (Faker $faker, $data = []) {


    if(!empty($data['user_id'])) {
        $user_id = $data['user_id'];
    } else {
        $user_id = User::inRandomOrder()->get()->first()->id;
    }

    if(!empty($data['post_id'])) {
        $post_id = $data['post_id'];
    } else {
        $post_id = Post::inRandomOrder()->get()->first()->id;
    }

    if(!empty($data['action'])) {
        $action = $data['action'];
    } else {
        $action = 'save';
    }

    return [
        'post_id' => $post_id,
        'user_id' => $user_id,
        'action' => $action,
    ];
});
