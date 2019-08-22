<?php

namespace Tests\Feature;

use App\Interaction;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostTest extends TestCase
{

    /**
     * @test
     * ./vendor/bin/phpunit --filter test_post_video tests/Feature/PostTest.php
     */
    public function test_post_video() {
        $data = [
            'photo' => '',
            'type' => 'video',
            'video' => 'https://www.youtube.com/watch?time_continue=205&v=xGI1wZIM2rE',
            'description' => 'This is the video that inspire me a lot and make more productive in what i want to do',
            'title' => 'My youtube video',
            'url' => '',
            'page' => 'add',
            'action' => 'store',
            'section' => 'videos'
        ];

        // Do the upload via http request
        $response = $this->json('POST', 'api/post/store', $data);

        $original = $response->original;

        $title1 = $data['title'];
        $title2 = $original['data']['post']['title'];

        $this->assertEquals($title1,  $title2);

        $response->assertStatus(200);
    }

    /*
    * @test
    * ./vendor/bin/phpunit --filter test_post_portfolio_image tests/Feature/PostTest.php
    */
    public function test_post_portfolio_image() {
        // Create fake profile
        Storage::fake('posts');

        $data = [
            'photo' => UploadedFile::fake()->image('new-post.jpg'),
            'type' => 'photo',
            'video' => '',
            'description' => 'I am the creator and founder of this website',
            'title' => 'Great experience',
            'url' => 'https://wwww.shoppemarket.com',
            'page' => 'add',
            'action' => 'store',
            'section' => 'portfolio'

        ];

        // Do the upload via http request
        $response = $this->json('POST', 'api/post/store', $data);

        // Get original data
        $original = $response->original;

        // get post id
        $post_id = $original['data']['post']['id'];

        // Assert the file was stored...
        Storage::disk('posts')->assertExists($post_id . '/' . 'new-post.jpg');

        // Assert a file does not exist...
        Storage::disk('posts')->assertMissing($post_id . '/' . 'new-post-missing.jpg');

        $original = $response->original;

        $message = $original['message'];

        $this->assertEquals('Successfully posted', $message);

        $response->assertStatus(200);
    }

    /*
    * @test
    * ./vendor/bin/phpunit --filter test_update_portfolio_information tests/Feature/PostTest.php
    */
    public function test_update_portfolio_information() {
        // create new post
        $post = factory(Post::class)->create([
            'user_id' => $this->auth->id
        ]);

        // set data
        $data = [
            'description' => 'I am the creator and founder of this website',
            'title' => 'Shoppe market',
            'url' => 'https://wwww.shoppemarket.com',
            'type' => 'photo',
            'action' => 'update',
            'section' => 'portfolio'
        ];

        // url
        $response = $this->post('api/post/' . $post->id . '/update', $data);

        $original = $response->original;
        $description1 = $data['description'];
        $description2 = $original['data']['post']['description'];

        $this->assertTrue($description1 == $description2);

        // status
        $response->assertStatus(200);
    }

    /*
     * @test
     * ./vendor/bin/phpunit --filter test_delete_portfolio tests/Feature/PostTest.php
     */
    public function test_delete_portfolio() {
        // create new post
        $post = factory(Post::class)->create([
            'user_id' => $this->auth->id
        ]);

        // trigger url
        $response = $this->post('api/post/' . $post->id . '/delete');

        // check if found the new contact send
        $original = $response->original;

        $deleted = $original['data']['deleted'];

        $this->assertTrue($deleted);

        // check if status 200
        $response->assertStatus(200);
    }

    /*
     * @test
     * ./vendor/bin/phpunit --filter test_load_more_portfolio tests/Feature/PostTest.php
     */
    public function test_load_more_portfolio() {
        $user = factory(User::class)->create();

        factory(Post::class, 30)->create([
            'user_id' => $user->id
        ]);

        // set data
        $data1 = [
            'offset' => 0,
            'limit' => 5,
            'user_id' => $user->id,
        ];

        $data2 = [
            'offset' => 5,
            'limit' => 5,
            'user_id' => $user->id,
        ];

        $data3 = [
            'offset' => 10,
            'limit' => 5,
            'user_id' => $user->id,
        ];

        // trigger url
        $response1 = $this->post('api/post/search', $data1);
        $response2 = $this->post('api/post/search', $data2);
        $response3 = $this->post('api/post/search', $data3);

        // get data
        $original1 = $response1->original;
        $original2 = $response2->original;
        $original3 = $response3->original;

        // assign data
        $description1 = $original1['data']['posts'][0]['description'];
        $description2 = $original2['data']['posts'][0]['description'];
        $description3 = $original3['data']['posts'][0]['description'];

        // check if 1, 2 and 3 are not the same
        $this->assertTrue(($description1 != $description2) && ($description2 != $description3));

        // check status 1, 2, 3 responses
        $response1->assertStatus(200);
        $response2->assertStatus(200);
        $response3->assertStatus(200);
    }
}