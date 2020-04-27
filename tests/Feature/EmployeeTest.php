<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\Library\TestFactory;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected $factory;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->factory = new TestFactory();
    }

    public function test_register_employee()
    {
        Artisan::call('passport:install');

        $this->factory
            ->createUser()
            ->generateRolesAndPermissions()
            ->signIn($this);

        $attributes = [
            'first_name' => 'John',
            'middle_name' => 'Smith',
            'last_name' => 'Doe',
            'birth_date' => '03/15/1990',
            'gender' => 'male',
            'address' => 'Iligan City',
            'contact_number' => '09161010995',
            'fb_url' => 'www.facebook.com/john.doe',
            'civil_status' => 'single',
            'type' => 'employee',
            'email' => 'johndoe@gmail.com',
            'password' => 'password'
        ];

        $response = $this->post('api/employee', $attributes);

        $result = $response->getOriginalContent()['employee'];

        $this->assertEquals($attributes['first_name'], $result['first_name']);

        $response->assertStatus(200);
    }

    public function test_employee_list()
    {
        Artisan::call('passport:install');

        $this->factory
            ->createUser()
            ->signIn($this)
            ->createEmployee(5);

        $attributes = [
            'limit' => 5,
            'page' => 1,
            'sort' => 'desc'
        ];

        $response = $this->get('api/employee?' . http_build_query($attributes));

        $data = $response->getOriginalContent()['employees'];

        $this->assertEquals(5, $data->count());

        $response->assertOk();
    }
}
