<?php

namespace Tests;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\User;
use App\Message;
//use App\Post;
//use App\Interaction;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    use CreatesApplication;

    public $users;
//    public $userPosts;
//    public $allPosts;
//    public $auth;

    public function setUp()
    {
        // Init setup
        parent::setUp();

//        $this->auth = factory(User::class, 1)->create([
//            'email' => 'mrjesuserwinsuarez@gmail.com',
//            'name' => 'Vic Datu Andam',
//            'slug' => 'vic-datu-andam'
//        ])->first();

//        $this->actingAs($this->auth);

        // create users
//        $this->users = factory(User::class, 20)->create();
//        $this->messages = factory(Message::class, 30)->create();

//        // Auth user
//        $this->auth = User::inRandomOrder()->get()->first();
//        $this->actingAs($this->auth);
//
//        // create posts
//        $this->allPosts = factory(Post::class, 50)->create();
//
//        // create posts for specific user logged in
//        $this->userPosts = factory(Post::class, 2)->create([
//            'user_id' => $this->auth->id
//        ]);
//
//        // Current auth user inspire 2 posts
//        factory(Interaction::class, 2)->create([
//            'user_id' => $this->auth->id,
//            'action' => 'inspire'
//        ]);
//
//        // Current auth user save 2 posts
//        factory(Interaction::class, 2)->create([
//            'user_id' => $this->auth->id,
//            'action' => 'save'
//        ]);
    }
}
