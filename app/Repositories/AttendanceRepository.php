<?php

namespace App\Repositories;

use App\Attendance;
use App\Employee;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

date_default_timezone_set('Asia/Manila');

/**
 * Class AttendanceRepository.
 */
class AttendanceRepository extends BaseRepository
{
    public $status = 200;
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Attendance::class;
    }

    public function getAttendanceList($request)
    {
        $attendance = Attendance::with('employee')
            ->orderByDesc('id')
            ->get();

        return $attendance;
    }

    public function getAuthUserAttendance()
    {
        $attendance = Attendance::with('employee')
            ->where('employee_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return $attendance;
    }

    public function storeAttendance($request)
    {
        $attendance = new Attendance();

        $attendance->status  = $request->status;
        $attendance->user_id = auth()->id();

        $attendance->save();

        return $attendance;
    }
}
