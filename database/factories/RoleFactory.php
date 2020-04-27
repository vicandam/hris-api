<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model;
use App\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => 'admin',
        'guard_name' => 'web',
    ];
});
