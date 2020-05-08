<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Attendance;

$factory->define(Attendance::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(array('in', 'out')),
        'user_id' => 1
    ];
});
