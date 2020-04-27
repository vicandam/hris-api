<?php
namespace Tests\Library;

use App\Attendance;
use App\Employee;
use App\Role;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class TestFactory extends TestCase
{
    public $user, $users;
    public $employee, $employees;
    public $attendance, $attendances;

    public function generateRolesAndPermissions()
    {
        $this->roles['admin'] = factory(Role::class)->create(['guard_name' => 'web', 'name' => 'admin']);
        $this->roles['employee'] = factory(Role::class)->create(['guard_name' => 'web', 'name' => 'employee']);

        return $this;
    }

    public function createUser($total=1, $attr=[])
    {
        if ($total > 1) {
            for ($i=0; $i < $total; $i++) {
                $this->users[] = Passport::actingAs(factory(User::class)->create($attr));
            }

            $this->createInstance('users', $this->users);
        } else {
            $this->user = Passport::actingAs(factory(User::class)->create($attr));
            $this->createInstance('user', $this->user);
        }

        return $this;
    }
    public function createEmployee($total=1, $attr=[])
    {
        if ($total > 1) {
            for ($i=0; $i < $total; $i++) {
                $this->employees[] = factory(Employee::class)->create($attr);
            }

            $this->createInstance('employees', $this->employees);
        } else {
            $this->employee = factory(Employee::class)->create($attr);

            $this->createInstance('employee', $this->employee);
        }

        return $this;
    }
    public function createAttendance($total=1, $attr=[])
    {
        if ($total > 1) {
            for ($i=0; $i < $total; $i++) {
                $this->attendances[] = factory(Attendance::class)->create($attr);
            }

            $this->createInstance('attendances', $this->attendances);
        } else {
            $this->attendance = factory(Attendance::class)->create($attr);

            $this->createInstance('$this->attendance', $this->attendance);
        }

        return $this;
    }

    public function createInstance($key, $instance)
    {
        $this->instances[$key] = $instance;
    }
    public function signIn($system)
    {
        $system->actingAs($this->user);

        return $this;
    }
}
