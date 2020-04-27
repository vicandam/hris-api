<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Employee;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->date(),
        'gender' => $faker->randomElement(array('male', 'female')),
        'address' => $faker->address,
        'contact_number' => $faker->phoneNumber,
        'fb_pro_url' => 'http://www.facebook.com/john.doe',
        'civil_status' => $faker->randomElement(array('single', 'married', 'widowed')),
        'type' => $faker->randomElement(array('employee', 'admin')),
        'user_id' => 1
    ];
});
