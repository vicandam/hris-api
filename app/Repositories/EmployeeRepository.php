<?php

namespace App\Repositories;

use App\Attendance;
use App\Employee;
use App\User;
use Carbon\Carbon;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository extends BaseRepository
{
    public $status = 200;

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Employee::class;
    }

    public function getAllEmployee()
    {
        return Employee::all();
    }

    public function storeEmloyee($input)
    {
        $user           = new User();

        $user->name     = $input['first_name'] . ' ' . $input['middle_name'] . ' ' . $input['last_name'];
        $user->email    = $input['email'];
        $user->password = bcrypt($input['password']);

        $user->save();

        $user->assignRole('employee');

        $employee = new Employee();

        $employee->first_name     = $input['first_name'];
        $employee->middle_name    = $input['middle_name'];
        $employee->last_name      = $input['last_name'];
        $employee->birth_date     = $input['birth_date'];
        $employee->contact_number = $input['contact_number'];
        $employee->fb_pro_url     = $input['fb_url'];
        $employee->civil_status   = $input['civil_status'];
        $employee->type           = $input['type'];
        $employee->user_id        = $user->id;

        $employee->save();

        return $employee;
    }

    public function updateProfile($input)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        $employee->first_name     = $input['first_name'];
        $employee->middle_name    = $input['middle_name'];
        $employee->last_name      = $input['last_name'];
        $employee->birth_date     = $input['birth_date'];
        $employee->gender         = $input['gender'];
        $employee->address        = $input['address'];
        $employee->contact_number = $input['contact_number'];
        $employee->fb_pro_url     = $input['fb_url'];

        $employee->save();

        return $employee;
    }
}
