<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * ./vendor/bin/phpunit --filter UserTest tests/Feature/UserTest.php
 * Class UserTest
 * @package Tests\Feature
 */
class UserTest extends TestCase
{
    /**
     * @test
     * ./vendor/bin/phpunit --filter test_visit_home tests/Feature/UserTest.php
     */
    public function test_visit_home() {
        // load url
        $response =  $this->get('/');

        // check if the status is 200
        $response->assertStatus(200);
    }
    /*
     * @test
     * ./vendor/bin/phpunit --filter test_load_user_information tests/Feature/UserTest.php
     */
    public function test_load_user_information() {
        // load user info via url
          $response =  $this->post('api/user/profile/load');

        // check if found a result or not and it should be found
        $original = $response->original;

        $id = $original['data']['user']['id'];

        // check status if success
        $this->assertTrue($id > 0);

        // check status if success
        $response->assertStatus(200);
    }
    /*
     * @test
     * ./vendor/bin/phpunit --filter test_guest_load_user_information tests/Feature/UserTest.php
     */
    public function test_guest_load_user_information() {
        // logout current user
        auth()->logout();

        // load user info via url
          $response =  $this->post('api/user/profile/load');

        // check if found a result or not and it should be found
        $original = $response->original;

        $id = $original['data']['user']['id'];

        // check status if success
        $this->assertTrue($id > 0);

        // check status if success
        $response->assertStatus(200);
    }
    /*
     * @test
     * ./vendor/bin/phpunit --filter test_guest_load_user_information_default_is_for_jesus tests/Feature/UserTest.php
     */
    public function test_guest_load_user_information_default_is_for_jesus() {
        // logout current user
        auth()->logout();

        // load user info via url
          $response =  $this->post('api/user/profile/load');

        // check if found a result or not and it should be found
        $original = $response->original;

        $email = $original['data']['user']['email'];

        // check status if success
        $this->assertTrue($email == 'mrjesuserwinsuarez@gmail.com');

        // check status if success
        $response->assertStatus(200);
    }
    /*
     * @test
     * ./vendor/bin/phpunit --filter test_update_about tests/Feature/UserTest.php
     */
    public function test_update_about() {
        $data =  [
            'name' => 'Vic Datu Andam',
            'position' => 'CEO, Founder and a creator / Project Manager / Web Developer',
            'about' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like y web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometime',
            'section' => 'basic information'
        ];

        // load user info via url
        $response =  $this->post('api/user/profile/update', $data);

       // check status if success
        $response->assertStatus(200);
    }
    /*
    * @test
    * ./vendor/bin/phpunit --filter test_upload_change_profile_pic tests/Feature/UserTest.php
    */
    public function test_upload_change_profile_pic() {
            $data = [
                'photo' => UploadedFile::fake()->image('avatar.jpg'),
                'section' => 'profile photo'
            ];

            // Create fake profile
            Storage::fake('profile');

            // Initialized the auth user
            $auth = auth()->user();

            // Do the upload via http request
            $response = $this->json('POST', 'api/user/profile/update/photo', $data);

            // Assert the file was stored...
            Storage::disk('profile')->assertExists($auth->id . '/' . 'avatar.jpg');

            // Assert a file does not exist...
            Storage::disk('profile')->assertMissing($auth->id . '/' . 'missing.jpg');

            $response->assertStatus(200);
    }
    /*
  * @test
  * ./vendor/bin/phpunit --filter test_delete_profile_pic tests/Feature/UserTest.php
  */
    public function test_delete_profile_pic() {
        $data = [
            'photo' => UploadedFile::fake()->image('avatar.jpg'),
            'section' => 'profile photo'
        ];

        // Create fake profile
        Storage::fake('profile');

        // Initialized the auth user
        $auth = auth()->user();

        // Do the upload via http request
        $response = $this->json('POST', 'api/user/profile/update/photo', $data);

        // delete now
        $status1 = Storage::disk('profile')->delete($auth->id . '/' . 'avatar.jpg');

        // not able to delete

        $status2 = Storage::disk('profile')->delete($auth->id . '/' . 'avatar1.jpg');

        // check if successdully deleted
        $this->assertTrue($status1);

        // check if failed to delete
        $this->assertTrue($status2 == false);

        // status is
        $response->assertStatus(200);
    }
    /*
    * @test
    * ./vendor/bin/phpunit --filter test_update_history tests/Feature/UserTest.php
    */
    public function test_update_history() {
        $data =  [
            'history_title' => 'My History',
            'history_description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like y web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometime',
            'section' => 'history'
        ];

        // load user info via url
        $response =  $this->post('api/user/profile/update', $data);

        // check status if success
        $response->assertStatus(200);
    }
    /*
    * @test
    * ./vendor/bin/phpunit --filter test_update_contact_email tests/Feature/UserTest.php
    */
    public function test_update_contact_email() {
        $data =  [
            'contact_email' => 'contactme@jesus.com',
            'section' => 'contact us'
        ];

        // load user info via url
        $response =  $this->post('api/user/profile/update', $data);

        // check status if success
        $response->assertStatus(200);
    }
}
