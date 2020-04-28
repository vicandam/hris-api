<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Library\TestFactory;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected $factory;

    function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->factory = new TestFactory();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signed_in()
    {
        $this->factory
            ->createUser()
            ->createEmployee()
            ->signIn($this);

        $attribute = [
            'status' => 'in'
        ];

        $response = $this->post('api/attendance', $attribute);

        $result = $response->getOriginalContent()['attendance'];

        $this->assertEquals('IN', $result['status']);

        $response->assertOk();
    }
    public function test_signed_out()
    {
        $this->factory
            ->createUser()
            ->createEmployee()
            ->signIn($this);

        $attribute = [
            'status' => 'out'
        ];

        $response = $this->post('api/attendance', $attribute);

        $result = $response->getOriginalContent()['attendance'];

        $this->assertEquals('OUT', $result['status']);

        $response->assertOk();
    }

    public function test_attendance_list()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createEmployee(10)
            ->createAttendance(10);

        $attributes = [
            'paginate' => 10,
            'page' => 1
        ];

        $response = $this->get('api/attendance?' . http_build_query($attributes));

        $result = $response->getOriginalContent()['message'];

        $this->assertEquals('attendance successfully retrieved', $result);

        $response->assertOk();
    }
    public function test_auth_attendance()
    {
        $this->factory
            ->createUser()
            ->signIn($this)
            ->createEmployee()
            ->createAttendance();

        $attributes = [
            'paginate' => 10,
            'page' => 1
        ];

        $response = $this->get('api/auth-attendance?' . http_build_query($attributes));

        $result = $response->getOriginalContent()['message'];

        $this->assertEquals('attendance successfully retrieved', $result);

        $response->assertOk();
    }
}
