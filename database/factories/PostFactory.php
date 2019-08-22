<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker, $param) {

    $user_id = (!empty($param['user_id']) ? $param['user_id'] : 0);
//    $description = (!empty($param['description']) ? $param['description'] : 0);
//    $type = (!empty($param['type']) ? $param['type'] : '');



    if($user_id > 0) {
        $user = User::find($user_id);
    } else {
        $user  = User::inRandomOrder()->get()->first();
    }

    $photo = '';
    $video = '';

    $typeOption = ['photo', 'video', 'text'];
    $type = $typeOption[rand(0, count($typeOption) - 1)];

    if ($type == 'video') {
        $data = [
            'https://www.youtube.com/watch?v=poYZ84diF44&list=RDf8TkUMJtK5k&index=4',
            'https://www.youtube.com/watch?v=FBJJJkiRukY&list=RDf8TkUMJtK5k&index=6',
            'https://www.youtube.com/watch?v=V8vym4gtcEM&list=RDf8TkUMJtK5k&index=12',
            'https://www.youtube.com/watch?v=QRnFFTxnuCo'
        ];

        $video = $data[rand(0, count($data) - 1)];
    } else if ($type == 'photo') {
        $photo = $faker->imageUrl();
    }

    return [
        'user_id' => $user->id,
        'description' =>  (!empty($description) ) ? $description : $faker->paragraph(1),
        'video' => $video,
        'photo' => $photo,
        'type' => $type
    ];
});
