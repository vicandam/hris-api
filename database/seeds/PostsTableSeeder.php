<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;
use Faker\Factory;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $users = User::all();

        $typeOption = ['photo', 'video', 'text'];

        foreach($users as $user) {
            for($i=0; $i<rand(3,5); $i++) {
                $type = $typeOption[rand(0, count($typeOption) - 1)];

                $post = new Post();
                $post->user_id = $user->id;
                $post->description = $faker->paragraph(5);
                $post->title = $faker->paragraph(1);

                if ($type == 'video') {
                    $data = [
                        'https://www.youtube.com/watch?v=poYZ84diF44&list=RDf8TkUMJtK5k&index=4',
                        'https://www.youtube.com/watch?v=FBJJJkiRukY&list=RDf8TkUMJtK5k&index=6',
                        'https://www.youtube.com/watch?v=V8vym4gtcEM&list=RDf8TkUMJtK5k&index=12',
                        'https://www.youtube.com/watch?v=QRnFFTxnuCo'
                    ];

                    $video = $data[rand(0, count($data) - 1)];

                    $post->video = $video;
                } else if ($type == 'photo') {
                    $post->photo = $faker->imageUrl();
                }

                $post->type = $type;

                $post->save();
            }
        }
    }
}
