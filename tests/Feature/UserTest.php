<?php

namespace Tests\Feature;

use App\Employee;
use App\User;
use Tests\Library\TestFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

/**
 * ./vendor/bin/phpunit --filter UserTest tests/Feature/UserTest.php
 * Class UserTest
 * @package Tests\Feature
 */
class UserTest extends TestCase
{
    function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->factory = new TestFactory();
    }

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
    /** API test */
    public function test_create_user()
    {
        Artisan::call('passport:install');

        $this->factory
            ->createUser()
            ->signIn($this);

        $attribute = [
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post('api/users', $attribute);

        $token = $response->getOriginalContent()['data']['token'];
        $user  = $response->getOriginalContent()['data']['user'];
        $this->assertNotEmpty($token);
        $this->assertNotEmpty($user);

        $response->assertStatus(200);
    }
    public function test_logged_in_user_update_their_profile()
    {
        Artisan::call('passport:install');

        $this->factory
            ->createUser()
            ->signIn($this)
            ->createEmployee();

        $attributes = [
            'first_name' => 'John',
            'middle_name' => 'Smith',
            'last_name' => 'Doe',
            'birth_date' => 'Thu May 31 2018 00:00:00 GMT+0800',
            'gender' => 'male',
            'address' => 'Iligan City',
            'contact_number' => '09161010995',
            'fb_url' => 'www.facebook.com/john.doe',
            'civil_status' => 'single'
        ];

        $response = $this->post('api/employee/update-profile', $attributes);

        $result = $response->getOriginalContent()['user'];

        $this->assertEquals($attributes['first_name'], $result['first_name']);

        $response->assertStatus(200);

    }
    public function test_admin_update_user()
    {
        $this->factory
            ->createUser()
            ->signIn($this);

        $attribute = [
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('password')
        ];

        $response = $this->patch('api/users/' . $this->factory->user->id, $attribute);

        $this->assertEquals($attribute['email'], $response->getOriginalContent()['data']['user']['email']);

        $response->assertStatus(200);
    }
    public function test_admin_delete_employee()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createEmployee();

        $response = $this->delete('api/employee/' . $this->factory->employee->id);

        $result = $response->getOriginalContent()['message'];

        $this->assertEquals($result, 'Successfully deleted.');

        $response->assertStatus(200);
    }


    public function test_authenticate_user()
    {
        Artisan::call('passport:install');

        $this->factory
            ->createUser(1,
                [
                    'name' => 'jane doe',
                    'email' => 'janedoe@gmail.com',
                    'password' => bcrypt('password')
                ]);

        $attributes = [
            'email' => 'janedoe@gmail.com',
            'password' => 'password'
        ];

        $response = $this->post('api/login', $attributes);

        $data = $response->getOriginalContent();

        $this->assertNotEmpty($data['access_token']);

        $this->assertEquals($data['message'], 'login successful');
    }
    public function test_invalid_credentials()
    {
        Artisan::call('passport:install');

        $this->factory
            ->createUser(1,
                [
                    'name' => 'jane doe',
                    'email' => 'janedoe@gmail.com',
                    'password' => bcrypt('password')
                ]);

        $attributes = [
            'email' => 'janedoe@gmail.com',
            'password' => 'passwor'
        ];

        $response = $this->post('api/login', $attributes);

        $data = $response->getOriginalContent();

        $this->assertEquals($data['message'], 'Invalid credentials');
    }

    public function test_retrieve_users()
    {
        $this->factory
            ->createUser();

        $attributes = [
            'limit' => 5,
            'page' => 1,
            'sort' => 'desc'
        ];

        $response = $this->get('api/users?' . http_build_query($attributes));

        $data = $response->getOriginalContent()['data']['users'];

        $this->assertEquals(22, $data['users']->count());

        $response->assertOk();
    }
    public function test_auth_profile()
    {
        $this->factory
            ->createUser()
            ->createEmployee()
            ->signIn($this);

        $attributes = [
            'name' => 'John Doe'
        ];

        $response = $this->get('api/auth-profile?' . http_build_query($attributes));

        $response->assertOk();
    }

    public function test_update_user_password()
    {
        $this->factory
            ->createUser()
            ->signIn($this);

        $attributes = [
            'current_password' => 'secret',
            'new_password'     => 'new_password',
            'confirm_password' => 'new_password'
        ];

        $url = 'api/user/update-password';

        $response = $this->post($url, $attributes);

        $response->assertOk();
    }
}
