<?php

namespace Tests\Feature;

use App\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\Library\TestFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $factory;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->factory = new TestFactory();
    }

    /**Skip for now
    public function test_send_sms()
    {
        $this->factory
            ->createUser()
            ->signIn($this);

        $attributes = [
            'number' => '09161010994',
            'message' => 'The quick brown fox jumps over the lazy dog.'
        ];

        $response = $this->post('api/send-sms', $attributes);

        $response->assertOk();
    }
     * */

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
            ->createUser(5);

        $attributes = [
          'limit' => 5,
          'page' => 1,
          'sort' => 'desc'
        ];

        $response = $this->get('api/users?' . http_build_query($attributes));

        $data = $response->getOriginalContent()['data']['users'];

        $this->assertEquals(5, $data['users']->count());

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
            'current_password' => 'password',
            'new_password'     => 'new_password',
            'confirm_password' => 'new_password'
        ];

        $url = 'api/user/update-password';

        $response = $this->post($url, $attributes);

        $response->assertOk();
    }
}
