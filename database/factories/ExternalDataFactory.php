<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\ExternalData::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->get()->first()->id,
        'response_id' => rand(1, 200),
        'score_id' => rand(1, 200),
        'answer_id' => rand(1, 200),
        'website' => 'stackoverflow',
        'type' => 'api',
        'data' => ''
    ];
});


//"last_activity_date" => 1530888690
//      "creation_date" => 1530888690
//      "answer_id" => 51212984
//      "question_id" => 51212874
